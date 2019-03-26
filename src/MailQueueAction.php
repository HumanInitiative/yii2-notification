<?php

namespace pkpudev\notification;

use app\models\Company;
use app\models\EmailQueue;
use app\models\Ipp;
use app\models\File;
use app\models\Project;
use pkpudev\notification\notify\IppStatusNotify;
use pkpudev\notification\notify\ProjectStatusNotify;
use pkpudev\notification\notify\StatusNotifyInterface;
use pkpudev\notification\transform\IppTransform;
use pkpudev\notification\transform\ProjectTransform;
use yii\base\Action;
use yii\base\UnknownClassException;
use pkpudev\notification\event\IppEvent;
use pkpudev\notification\event\ProjectEvent;

class MailQueueAction extends Action
{
    const MAX_ATTEMTPS = 5;
    const MAPCLASS_IPP = 'Ipp';
    const MAPCLASS_PROJECT = 'Project';

    public $mailer;
    public $controller;
    public $documentPath = "/home/devproject/AppMuliaProject/web";
    public $footerFile = '@app/views/mail/partial/footer.php';
    public $companyId;
    public $systemEmailAddress;

    protected $sender;

    public function init()
    {
        if (is_null($this->mailer)) {
            throw new UnknownClassException("mailer component is null", 500);
        }
        if (is_null($this->controller)) {
            throw new UnknownClassException("controller component is null", 500);
        }
        if (is_null($this->companyId)) {
            $this->companyId = Company::PKPU;
        }
        if (is_null($this->systemEmailAddress)) {
            $this->systemEmailAddress = \Yii::$app->params['systemEmailAddress'];
        }

        $sender = $this->systemEmailAddress[$this->companyId];
        $params = [
            'address'=>Company::getCompanyAddress($this->companyId),
            'company'=>Company::getCompanyName($this->companyId),
            'logo'=>Company::getCompanyLogo($this->companyId),
            'site'=>Company::getCompanySite($this->companyId),
            'subject'=>null,
            'title'=>null
        ];

        $viewMail = MailerFactory::makeView($this->controller, $this->footerFile, $params);
        $this->mailer = MailerFactory::composeMailer($this->mailer, $viewMail);
        $this->sender = MailerFactory::makeSender($sender['name'], $sender['email']);
    }

    public function run()
    {
        $mapClasses = [self::MAPCLASS_IPP, self::MAPCLASS_PROJECT];
        echo "--- Begin sending email --- \r\n";
        foreach ($mapClasses as $mapclass) {
            $count = $this->runDbQueue($mapclass);
            echo "--- Send ".$count." emails --- \r\n";
            if ($count) {
                $retval = json_encode(compact('mapclass', 'count'));
                var_dump($retval);
            }
        }
        echo "--- End sending email --- \r\n";
    }

    /**
     * Run Db Queue
     * 
     * @param string $mapclass
     * @return int
     */
    protected function runDbQueue($mapclass)
    {
        $queueList = EmailQueue::find()
            ->where(['mapclass_name'=>$mapclass])
            ->andWhere(['or', ['success'=>null], ['not', ['success'=>1]]])
            ->andWhere(['or', ['attempts'=>null], ['<=', 'attempts', self::MAX_ATTEMTPS]])
            ->all();

        $emailSentCount = 0;
        foreach ($queueList as $queue) {
            $statusNotify = $this->getStatusNotify($queue);
            if ($this->sendmail($statusNotify, $queue->list_files)) {
                $queue->success = 1;
                $queue->date_sent = date('Y-m-d H:i:s');
                $emailSentCount++;
            }
            $queue->attempts += 1;
            $queue->last_attempt = date('Y-m-d H:i:s');
            $queue->save(false);
        }
        return $emailSentCount;
    }

    /**
     * Get StatusNotify
     * 
     * @param EmailQueue $queue
     * @return StatusNotifyInterface
     */
    protected function getStatusNotify(EmailQueue $queue)
    {
        if ($queue->mapclass_name == self::MAPCLASS_IPP) {            
            $model = Ipp::findOne($queue->mapclass_id);
            $transform = new IppTransform($model);
            $event = new IppEvent($model, $queue->notif_type);
            return new IppStatusNotify($transform, $event);
        } elseif ($queue->mapclass_name == self::MAPCLASS_PROJECT) {
            $model = Project::findOne($queue->mapclass_id);
            $transform = new ProjectTransform($model);
            $event = new ProjectEvent($model, $queue->notif_type);
            return new ProjectStatusNotify($transform, $event);
        } else {
            return null;
        }
    }

    /**
     * Send Mail
     * 
     * @param StatusNotifyInterface $statusNotify
     * @param json $listFileJson
     * @return bool
     */
    protected function sendmail(StatusNotifyInterface $statusNotify, $listFileJson)
    {
        $viewFile = $statusNotify->getViewFile();
        $message = $statusNotify->getMessage();
        $toEmail = $message->to;
        $ccEmail = $message->cc;
        $subject = $message->subject;
        $params = (array)$statusNotify->getParams();
        $message = $this->mailer->compose($viewFile, compact('params'));

        $files = @json_decode($listFileJson);
        if (is_array($files) && count($files)) {
            foreach ($files as $id) {
                if ($file = File::findOne($id)) {
                    $message->attach("{$this->documentPath}{$file->location}");
                }
            }
        }

        return $message
            ->setFrom($this->sender->getEmail())
            ->setTo($toEmail)
            ->setCC($ccEmail)
            ->setSubject($subject)
            ->send();
    }
}
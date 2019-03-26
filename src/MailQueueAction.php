<?php

namespace pkpudev\notification;

use app\models\Company;
use app\models\EmailQueue;
use app\models\Ipp;
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
        $mapClasses = [/*self::MAPCLASS_IPP,*/ self::MAPCLASS_PROJECT];
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
            if ($this->sendmail($statusNotify)) {
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
     * @return bool
     */
    protected function sendmail(StatusNotifyInterface $statusNotify)
    {
        $viewFile = $statusNotify->getViewFile();
        $message = $statusNotify->getMessage();
        $params = (array)$statusNotify->getParams();

        return $this->mailer
            ->compose($viewFile, $params)
            ->setFrom($this->sender->getEmail())
            ->setTo($message->to)
            ->setCC($message->cc)
            ->setSubject($message->subject)
            ->send();

        //$this->mailer->Host     = 'mail.pkpu.or.id'; /*'120.89.94.205'*/
        /*$this->mailer->isSMTP();  // Set mailer to use SMTP
        $this->mailer->Host = '184.173.153.194'; //smtp.mailgun.org
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'postmaster@mg.pkpu.or.id';
        $this->mailer->Password = 'fb7ce3982c9c2ab7df5ea6a55bd00197';
        $this->mailer->SMTPSecure = 'tls';*/
        /*$this->mailer->From     = $queueItem->from_email;
        $this->mailer->FromName = $queueItem->from_name;
        $this->mailer->AddReplyTo('project@pkpu.or.id'); //TODO

        $split = explode(',', $queueItem->to_email);
        if (count($split)>0 && !empty($split[0])) {
            foreach ($split as $to_email) {
                if (filter_var(trim($to_email), FILTER_VALIDATE_EMAIL)) {
                    $this->mailer->AddAddress($to_email);
                } elseif (filter_var(trim($queueItem->to_email), FILTER_VALIDATE_EMAIL)) {
                    $this->mailer->AddAddress($queueItem->to_email);
                }
            }
        }

        $split = explode(',', $queueItem->cc_email);
        if (count($split)>0 && !empty($split[0])) {
            foreach ($split as $cc_email) {
                if (filter_var(trim($cc_email), FILTER_VALIDATE_EMAIL)) {
                    $this->mailer->AddCC($cc_email);
                } elseif (filter_var(trim($queueItem->cc_email), FILTER_VALIDATE_EMAIL)) {
                    $this->mailer->AddCC($queueItem->cc_email);
                }
            }
        }

        $this->mailer->CharSet  = 'UTF-8';
        $this->mailer->Subject  = $queueItem->subject;
        $this->mailer->Body     = $content;
        $this->mailer->IsHTML(true);

        $files = @json_decode($queueItem->list_files);

        if (is_array($files) && count($files)) {
            foreach ($files as $id) {
                if ($file = File::model()->findByPK($id)) {
                    $this->mailer->addAttachment("{$this->documentPath}{$file->location}", $file->file_name);
                }
            }
        }*/

        // return $this->mailer->Send();
    }
}
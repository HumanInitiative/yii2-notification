<?php

namespace pkpudev\notification;

use yii\base\BaseObject;
use yii\db\ActiveRecordInterface;
use yii\db\Expression;

class MailQueue extends BaseObject
{
    /** @var EmailNotifJob $job */
    protected $job;

    /**
     * Class Constructor
     * 
     * @param EmailNotifJob $job
     */
    public function __construct(EmailNotifJob $job)
    {
        $this->job = $job;
    }

    /**
     * Push MailQueue
     *
     * @return bool
     */
    public function push()
    {
        $sender = $this->job->sender;
        $transform = $this->job->statusNotify->transform;
        $event = $this->job->statusNotify->event;
        $message = $this->job->statusNotify->getMessage();
        $model = $transform->model;
        $params = $transform->getParams();
        $command = $model->getDb()->createCommand();

        return $command->insert('pdg.email_queue', [
            'from_email' => $sender->userEmail,
            'from_name' => $sender->userName,
            'subject' => $message->subject,
            'mapclass_name' => get_class($model),
            'mapclass_id' => $model->id,
            'notif_type' => $event->getName(),
            'date_published' => new Expression('NOW()'),
            'company_id' => $this->getCompanyId($model),
            'branch_id' => $this->getBranchId($model),
            'param_data' => json_encode($params),
            'to_email' =>  $this->formatAddress($message->to),
            'cc_email' => $this->formatAddress($message->cc),
            'message' => $message->toString(),
        ])->execute();
    }

    protected function getCompanyId(ActiveRecordInterface $model)
    {
        if ($model->hasAttribute('company_id')) {
            return $model->company_id;
        } elseif ($model->getActiveRelation('project')) {
            return $model->project->company_id;
        } else {
            return 1; //PKPU
        }
    }

    protected function getBranchId(ActiveRecordInterface $model)
    {
        if ($model->hasAttribute('branch_id')) {
            return $model->branch_id;
        }
        return null;
    }

    public function formatAddress($messageAddress)
    {
        return implode(',', array_keys($messageAddress));
    }
}
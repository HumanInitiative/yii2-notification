<?php

namespace pkpudev\notification\behavior;

use pkpudev\notification\EmailNotifJob;
use pkpudev\notification\MailQueue;
use pkpudev\notification\event\ProjectActionEvent as Event;
use pkpudev\notification\notify\ProjectStatusNotify;
use pkpudev\notification\recipient\Recipient;
use pkpudev\notification\transform\ProjectTransform;
use yii\base\Behavior;
use yii\mail\MailerInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectEmailBehavior extends Behavior
{
    protected $mailQueue;
    protected $mailer;
    protected $sender;

    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function setSender(Recipient $sender)
    {
        $this->sender = $sender;
    }

    /**
     * Map events with their respective function
     */
    public function events()
    {
        return [
            // Project
            Event::EVENT_DRAFT => 'onEvent',
            Event::EVENT_CREATE => 'onEvent',
            Event::EVENT_UPDATE => 'onEvent',
            Event::EVENT_REVISION => 'onEvent',
            Event::EVENT_COMMENT => 'onEvent',
            Event::EVENT_VERIFY_QC => 'onEvent',
            Event::EVENT_VERIFY_RMD => 'onEvent',
            Event::EVENT_VERIFY_BKS => 'onEvent',
            Event::EVENT_RUNNING => 'onEvent',
            Event::EVENT_EXECUTING => 'onEvent',
            Event::EVENT_FINISHING => 'onEvent',
            Event::EVENT_VERIFYFINISH => 'onEvent',
            Event::EVENT_CLOSED => 'onEvent',
            Event::EVENT_REJECTED => 'onEvent',
            // ProjectFile
            Event::EVENT_UPLOAD_FILE => 'onEvent',
            Event::EVENT_DELETE_FILE => 'onEvent',
            // ProjectReport
            Event::EVENT_UPLOAD_REPORT => 'onEvent',
            // Alert
            Event::EVENT_ALERT_EXECDATE => 'onEvent',
        ];
    }

    /**
     * Triggered on event
     */
    public function onEvent($event)
    {
        $transform = new ProjectTransform($this->owner);
        $statusNotify = new ProjectStatusNotify($transform, $event);
        $job = new EmailNotifJob($this->mailer, $statusNotify, $this->sender);
        // Push Job
        $mailQueue = new MailQueue($job);
        $mailQueue->push();
    }
}
<?php

namespace pkpudev\notification;

use pkpudev\notification\notify\StatusNotifyInterface;
use pkpudev\notification\recipient\Recipient;
use yii\base\BaseObject;
use yii\mail\MailerInterface;
use yii\queue\JobInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class EmailNotifJob extends BaseObject implements JobInterface
{
    /**
     * @var MailerInterface
     */
    public $mailer;
    /**
     * @var StatusNotifyInterface
     */
    public $statusNotify;
    /**
     * @var Recipient
     */
    public $sender;

    /**
     * Class construct method
     *
     * @param MailerInterface $mailer
     * @param StatusNotifyInterface $statusNotify
     * @param Recipient $sender
     */
    public function __construct(MailerInterface $mailer, StatusNotifyInterface $statusNotify, Recipient $sender)
    {
        $this->mailer = $mailer;
        $this->statusNotify = $statusNotify;
        $this->sender = $sender;
    }

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        $viewFile = $this->statusNotify->getViewFile();
        $message = $this->statusNotify->getMessage();
        $params = (array)$this->statusNotify->getParams();

        return $this->mailer
            ->compose($viewFile, $params)
            ->setFrom($this->sender->getEmail())
            ->setTo($message->to)
            ->setSubject($message->subject)
            ->setCC($message->cc)
            ->send();
    }
}
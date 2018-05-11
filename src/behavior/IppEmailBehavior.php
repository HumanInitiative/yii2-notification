<?php

namespace pkpudev\notification\behavior;

use pkpudev\notification\EmailNotifJob;
use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\notify\IppStatusNotify;
use pkpudev\notification\transform\IppTransform;
use yii\base\Behavior;
use yii\mail\MailerInterface;
use yii\queue\Queue;

/**
 * Behavior for Ipp Model
 *
 * Compose mailer first
 *
 * ```php
 * $viewMail = MailerFactory::makeView(Yii::$app->controller, 'footer.php', []);
 * $mailer = MailerFactory::composeMailer(Yii::$app->mailer, $viewMail, $sender);
 * ```
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppEmailBehavior extends Behavior
{
	private $mailQueue;
	private $mailer;

	public function setMailQueue(Queue $mailQueue)
	{
		$this->mailQueue = $mailQueue;
	}

	public function setMailer(MailerInterface $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * Map events with their respective function
	 */
	public function events()
	{
		return [
			// Ipp
			Event::EVENT_CREATE => 'onEvent', //default
			Event::EVENT_SET_NEW => 'onEvent',
			Event::EVENT_APPROVE_KEU => 'onEvent',
			Event::EVENT_APPROVE_QC => 'onEvent',
			Event::EVENT_APPROVE_PDG => 'onEvent',
			Event::EVENT_REJECT => 'onEvent',
			Event::EVENT_REVISI_KEU => 'onEvent',
			Event::EVENT_FEE_MANAGEMENT => 'onEvent',
			// File
			Event::EVENT_UPLOAD_FILE => 'onEvent',
			Event::EVENT_DELETE_FILE => 'onEvent',
		];
	}

	/**
	 * Triggered on event
	 */
	public function onEvent($event)
	{
		$transform = new IppTransform($this->owner);
		$statusNotify = new IppStatusNotify($transform, $event);
		$sender = new Recipient; //TODO
		$job = new EmailNotifJob($this->mailer, $statusNotify, $sender);
		$this->mailQueue->push($job);
	}
}
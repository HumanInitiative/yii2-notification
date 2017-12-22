<?php

namespace pkpudev\notification;

use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class EmailNotifJob extends BaseObject implements JobInterface
{
	/**
	 * @var BaseMailer
	 */
	private $mailer;
	/**
	 * @var StatusNotifInterface
	 */
	private $statusNotif;

	/**
	 * Class construct method
	 * 
	 * @param BaseMailer $mailer
	 * @param StatusNotifInterface $statusNotif
	 */
	public function __construct(BaseMailer $mailer, StatusNotifInterface $statusNotif)
	{
		$this->mailer = $mailer;
		$this->statusNotif = $statusNotif;
	}

	/**
	 * @inheritdoc
	 */
	public function execute($queue)
	{
		return false;
	}

	/**
	 * Sending actual email
	 * 
	 * @param string $viewFile
	 * @param MailMessage $message
	 * @param array $params
	 * @return bool
	 */
	protected function send($viewFile, MailMessage $message, $params)
	{
		return false;
	}
}
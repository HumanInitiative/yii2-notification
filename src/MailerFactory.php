<?php

namespace pkpudev\notification;

use pkpudev\notification\recipient\Recipient;
use yii\mail\BaseMailer;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class MailerFactory
{
	/**
	 * Factory for Mailer
	 * 
	 * @param string $viewMail
	 * @param Recipient $recipient
	 * @param int $companyId
	 * @return BaseMailer
	 */
	public static function makeMailer($viewMail, Recipient $recipient, $companyId)
	{
		return new BaseMailer;
	}

	/**
	 * Factory for ViewMail
	 * 
	 * @param int $companyId
	 * @param string $title
	 * @param string $subject
	 * @return ViewMail
	 */
	public static function makeView($companyId, $title, $subject)
	{
		return new ViewMail;
	}

	/**
	 * Factory for sender/recipient
	 * 
	 * @return Recipient
	 */
	public static function makeSender()
	{
		return new Recipient;
	}

	/**
	 * Get Footer Html
	 * 
	 * @param Controller $controller
	 * @param int $companyId
	 * @return string
	 */
	protected static function getFooterHtml($controller, $companyId)
	{
		return null;
	}
}
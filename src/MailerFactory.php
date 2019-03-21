<?php

namespace pkpudev\notification;

use pkpudev\notification\recipient\Recipient;
use yii\base\Controller;
use yii\mail\MailerInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class MailerFactory
{
	/**
	 * Compose Mailer
	 * 
	 * @param MailerInterface $mailer
	 * @param ViewMail $viewMail
	 * @return MailerInterface
	 */
	public static function composeMailer(MailerInterface $mailer, ViewMail $viewMail)
	{
		$mailer->setView($viewMail);
		return $mailer;
	}

	/**
	 * Factory for ViewMail
	 * 
	 * @param Controller $controller
	 * @param string $footerFile
	 * @param array $params
	 * @return ViewMail
	 */
	public static function makeView(Controller $controller, $footerFile, $params)
	{
		$required = ['address','company','logo','site','subject','title'];
		static::parameterChecking($required, $params);

		$footerHtml = $controller->renderPartial($footerFile, [
			'address'=>$params['address'],
			'company'=>$params['company'],
			'site'=>$params['site']
		]);

		$viewMail = new ViewMail;
		$viewMail->title = $params['title'];
		$viewMail->header = $params['subject'];
		$viewMail->footer = $footerHtml;
		$viewMail->companyLogo = $params['logo'];

		return $viewMail;
	}

	/**
	 * Factory for sender/recipient
	 * 
	 * @param string $name
	 * @param string $email
	 * @return Recipient
	 */
	public static function makeSender($name, $email)
	{
		$recipient = new Recipient;
		$recipient->userName = $name;
		$recipient->userEmail = $email;
		return $recipient;
	}

	/**
	 * Check parameters with required parameters
	 * 
	 * @return bool
	 */
	protected static function parameterChecking($required, $params)
	{
		$keys = array_keys($params); sort($keys);
		if ($keys != $required) {
			$result = str_repeat("'%s', ", count($required));
			$strstr = substr($result, 0, strlen($result)-2);
			$message = vsprintf("Need {$strstr} parameters!", $required);
			throw new yii\base\InvalidConfigException($message);
		}
		return true;
	}
}
<?php

namespace pkpudev\notification\notify;

use pkpudev\notification\event\IppEvent;
use pkpudev\notification\ProgramHelper;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\RoleRecipentMapper;
use pkpudev\notification\transform\IppTransform;
use yii\db\ActiveRecordInterface;
use yii\swiftmailer\Message;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppStatusNotify implements StatusNotifyInterface
{
	private $transform;
	private $event;
	private $viewFile;
	private $recipientMapper;
	private $message;

	public function __construct(IppTransform $transform, IppEvent $event, $viewFile)
	{
		$this->transform = $transform;
		$this->event = $event;
		$this->viewFile = $viewFile;

		$model = $transform->getModel();
		$query = new RecipientQuery('Ipp', $model->company_id, $model->branch_id);
		$this->recipientMapper = new RoleRecipentMapper($query, $event);
	}
	/**
	 * @inheritdoc
	 */
	public function getMessage()
	{
		if ($this->message) {
			return $this->message;
		}

		// Compose subject
		$params = $this->transform->getParams();
		$subject = sprintf("%s IPP#%s %s %s",
			ProgramHelper::titlePrefix($params->is_ramadhan, $params->year),
			$params->no,
			$params->title,
			$this->event->eventDesc
		);
		// Compose mail
		$this->message = new Message;
		$this->message->to = $this->recipientMapper->getToAddress();
		$this->message->cc = $this->recipientMapper->getCcAddress();
		$this->message->subject = $subject;
		return $this->message;
	}
	/**
	 * @inheritdoc
	 */
	public function getParams()
	{
		return $this->transform->getParams();
	}
	/**
	 * @return string
	 */
	public function getViewFile()
	{
		return $this->viewFile;
	}
}
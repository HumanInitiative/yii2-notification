<?php

namespace pkpudev\notification\notify;

use pkpudev\notification\event\IppEvent;
use pkpudev\notification\transform\IppCommentTransform;
use yii\db\ActiveRecordInterface;
use yii\mail\MessageInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppCommentStatusNotify implements StatusNotifyInterface
{
	private $transform;
	private $event;
	private $viewFile;

	public function __construct(IppCommentTransform $transform, IppEvent $event, $viewFile)
	{
		$this->transform = $transform;
		$this->event = $event;
		$this->viewFile = $viewFile;
	}
	/**
	 * @inheritdoc
	 */
	public function getMessage()
	{
		// return new MailMessage;
	}
	/**
	 * @inheritdoc
	 */
	public function getToAddress(ActiveRecordInterface $model)
	{
		return [];
	}
	/**
	 * @inheritdoc
	 */
	public function getCcAddress(ActiveRecordInterface $model)
	{
		return [];
	}
	/**
	 * @return string
	 */
	public function getViewFile()
	{
		return $this->viewFile;
	}
}
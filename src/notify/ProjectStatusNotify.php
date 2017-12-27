<?php

namespace pkpudev\notification\notify;

use pkpudev\notification\event\ProjectEvent;
use pkpudev\notification\transform\ProjectTransform;
use yii\db\ActiveRecordInterface;
use yii\mail\MessageInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectStatusNotify implements StatusNotifyInterface
{
	private $transform;
	private $event;
	private $viewFile;

	public function __construct(ProjectTransform $transform, ProjectEvent $event, $viewFile)
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
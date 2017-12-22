<?php

namespace pkpudev\notification;

use yii\db\ActiveRecordInterface;

interface StatusNotifyInterface
{
	/**
	 * @return MailMessage
	 */
	public function getMessage();
	/**
	 * @return Recipient[]
	 */
	public function getToAddress(ActiveRecordInterface $model);
	/**
	 * @return Recipient[]
	 */
	public function getCcAddress(ActiveRecordInterface $model);
}
<?php

namespace pkpudev\notification\notify;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface StatusNotifyInterface
{
	/**
	 * @return yii\mail\MessageInterface;
	 */
	public function getMessage();
	/**
	 * @return object|array
	 */
	public function getParams();
}
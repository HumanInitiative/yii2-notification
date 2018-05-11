<?php

namespace pkpudev\notification\event;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface ModelEventInterface
{
	/**
	 * @var ActiveRecordInterface $model
	 * @var string $eventName From ActionEvent
	 */
	public function __construct(ActiveRecordInterface $model, $eventName);
}
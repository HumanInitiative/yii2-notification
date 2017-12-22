<?php

namespace pkpudev\notification\transform;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface DataTransformInterface
{
	/**
	 * Class constructor
	 * @param ActiveRecordInterface $model
	 */
	public function __construct(ActiveRecordInterface $model);
	/**
	 * @return object|array
	 */
	public function getParams();
}
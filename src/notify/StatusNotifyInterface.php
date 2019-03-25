<?php

namespace pkpudev\notification\notify;

use pkpudev\notification\transform\DataTransformInterface;
use pkpudev\notification\event\ModelEventInterface;

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
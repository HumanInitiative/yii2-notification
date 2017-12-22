<?php

namespace pkpudev\notification;

use yii\web\View;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ViewMail extends View
{
	/**
	 * @var string $companyLogo
	 */
	public $companyLogo;
	/**
	 * @var string $header
	 */
	public $header;
	/**
	 * @var string $footer
	 */
	public $footer;
}
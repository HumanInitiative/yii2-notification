<?php

namespace pkpudev\notification\recipient;

use yii\base\BaseObject;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class Recipient extends BaseObject
{
	/**
	 * @var int $companyId
	 */
	public $companyId;
	/**
	 * @var string $role
	 */
	public $role;
	/**
	 * @var int $userId
	 */
	public $userId;
	/**
	 * @var string $userName
	 */
	public $userName;
	/**
	 * @var string $userEmail
	 */
	public $userEmail;

	/**
	 * Class constructor
	 *
	 * @param array $config
	 */
	public function __construct($config=[])
	{
		parent::__construct($config);
	}

	/**
	 * Get valid email format
	 *
	 * @return array
	 */
	public function getEmail()
	{
		return [$this->userEmail=>$this->userName];
	}
}
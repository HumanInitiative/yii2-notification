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
	private $companyId;
	/**
	 * @var string $role
	 */
	private $role;
	/**
	 * @var int $userId
	 */
	private $userId;
	/**
	 * @var string $userName
	 */
	private $userName;
	/**
	 * @var string $userEmail
	 */
	private $userEmail;

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
	/**
	 * Get role
	 *
	 * @return string
	 */
	public function getRole()
	{
		return $this->role;
	}
}
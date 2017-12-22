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
		$this->companyId = $config['companyId'];
		$this->role = $config['role'];
		$this->userId = $config['userId'];
		$this->userName = $config['userName'];
		$this->userEmail = $config['userEmail'];

		parent::__construct($config);
	}
}
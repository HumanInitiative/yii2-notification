<?php

namespace pkpudev\notification\recipient;

use yii\base\BaseObject;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class RecipientQuery extends BaseObject
{
	/**
	 * @var Recipient[] $recipients
	 */
	private $recipients;

	/**
	 * Class constructor
	 * 
	 * @param string $model
	 * @param int $companyId
	 * @param int $branchId
	 */
	public function __construct($model, $companyId, $branchId=null)
	{
		// 
	}

	/**
	 * @return Recipient[]
	 */
	public function getAll()
	{
		return [];
	}

	/**
	 * @param string $role
	 * @return Recipient[]
	 */
	public function getByRole($role)
	{
		return [];
	}

	/**
	 * @param int $branchId
	 * @return Recipient[]
	 */
	public static function getFromBranch($branchId)
	{
		return [];
	}
}
<?php

namespace pkpudev\notification\recipient;

use yii\base\BaseObject;
use yii\db\Query;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class RecipientQuery extends BaseObject
{
	const BRANCH_PUSAT = 1;

	/**
	 * @var ModelName $modelName
	 */
	public $modelName;
	/**
	 * @var int $companyId
	 */
	public $companyId;
	/**
	 * @var int|null $branchId
	 */
	public $branchId;

	/**
	 * @var Recipient[] $recipients
	 */
	private $recipients = [];
	/**
	 * @var string $tableName
	 */
	private $tableName = 'pdg.sys_mail_recipient';

	/**
	 * Class constructor
	 * 
	 * @param ModelName $modelName
	 * @param int $companyId
	 * @param int $branchId
	 */
	public function __construct(ModelName $modelName, $companyId, $branchId=null)
	{
		$this->modelName = $modelName;
		$this->branchId = $branchId;
		$this->companyId = $companyId;

		$query = (new Query)
			->select('company_id, role, user_id, user_email, user_name')
			->from($this->tableName)
			->where(['is_active'=>1])
			->andWhere(['in', 'company_id', [0, $companyId]]);

		if (is_numeric($branchId) && $branchId != self::BRANCH_PUSAT) {
			$query
				->andWhere(['branch_id'=>$branchId])
				->andWhere(['model'=>ModelName::ALL]);
		} else {
			$query->andWhere(['model'=>$modelName->getName()]);
		}

		$this->recipients = array_map(function($row) {
			return new Recipient([
				'companyId'=>$row['company_id'],
				'role'=>$row['role'],
				'userId'=>$row['user_id'],
				'userEmail'=>$row['user_email'],
				'userName'=>$row['user_name'],
			]);
		}, $query->all());
	}

	/**
	 * @return Recipient[]
	 */
	public function getAll()
	{
		return $this->recipients;
	}

	/**
	 * @param string $role
	 * @return Recipient[]
	 */
	public function getByRole($role)
	{
		return array_filter($this->recipients, function($recipient) use ($role) {
			return $recipient->role == $role;
		});
	}

	/**
	 * Create from Branch
	 * @param int $companyId
	 * @param int $branchId
	 * @return RecipientQuery
	 */
	public static function fromBranch($modelName, $companyId, $branchId)
	{
		return new static($modelName, $companyId, $branchId);
	}
}
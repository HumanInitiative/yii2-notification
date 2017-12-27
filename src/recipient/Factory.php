<?php

namespace pkpudev\notification\recipient;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class Factory
{
	/**
	 * Make Recipient object from Employee
	 * @return Recipient
	 */
	public static function fromEmployee(ActiveRecordInterface $employee)
	{
		$recipient = new Recipient;
		$recipient->userId = $employee->id;
		$recipient->userName = $employee->name;
		$recipient->userEmail = $employee->pkpuEmail;
		$recipient->companyId = $employee->company_id;
		return $recipient;
	}
}
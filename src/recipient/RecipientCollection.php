<?php

namespace pkpudev\notification\recipient;

use yii\base\BaseObject;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class RecipientCollection extends BaseObject
{
	/**
	 * @var RecipientQuery $query
	 */
	private $query;

	/**
	 * Class constructor
	 * 
	 * @param RecipientQuery $query
	 */
	public function __construct(RecipientQuery $query)
	{
		$this->query = $query;
	}

	/**
	 * @return RecipientQuery
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * @return Recipient[]
	 */
	public function getRecipients()
	{
		return $this->query->getAll();
	}
}
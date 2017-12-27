<?php

namespace pkpudev\notification\recipient;

use pkpudev\notification\event\ModelEventInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class RoleRecipentMapper
{
	private $query;
	private $event;
	private $data;

	/**
	 * Class Constructor
	 *
	 * @param RecipientQuery $query
	 * @param ModelEventInterface $event
	 */
	public function __construct(RecipientQuery $query, ModelEventInterface $event)
	{
		$this->query = $query;
		$this->event = $event;

		$roles = [
			Role::KEMITRAAN, Role::KEU, Role::PDG, Role::QAQC,
			Role::RAMADHAN, Role::VERIFIKATOR, Role::VERIFIKATORKEU
		];
		foreach ($roles as $role) {
			$this->data[$role] = $this->query->getByRole($role);
		}
	}

	public function getToAddress()
	{
		return [];
	}

	public function getCcAddress()
	{
		return [];
	}
}
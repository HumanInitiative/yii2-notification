<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\Role;
use pkpudev\notification\transform\DataTransformInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppCcAddress implements RecipientAddressInterface
{
	/**
	 * @var DataTransformInterface $query
	 */
	private $transform;
	/**
	 * @var RecipientQuery $query
	 */
	private $query;
	/**
	 * @var ModelEventInterface $event
	 */
	private $event;

	/**
	 * @inheritdoc
	 */
	public function __construct(
		DataTransformInterface $transform,
		RecipientQuery $query,
		ModelEventInterface $event
	) {
		$this->transform = $transform;
		$this->query = $query;
		$this->event = $event;
	}

	/**
	 * @inheritdoc
	 */
	public function getAll()
	{
		$eventName = $this->event->name;
		$emails = null;

		if ($eventName == Event::EVENT_CREATE) {
			$emails = $this->query->getByRole(Role::KEU); // KEU
			$emails[] =	$this->transform->getCreatorEmail(); // CREA
			$emails[] =	$this->transform->getMarketerEmail(); // MRKT
			$emails[] =	$this->transform->getManagerMarketerEmail(); // MGRMRKT
		} elseif ($eventName == Event::EVENT_APPROVE_KEU) {
			$emails = array_merge(
				$this->query->getByRole(Role::PDG), // PDG
				$this->query->getByRole(Role::QAQC), // QAQC
				$this->query->getByRole(Role::VERKEU) // VERKEU
			);
			$emails[] =	$this->transform->getMarketerEmail(); // MRKT
			$emails[] =	$this->transform->getManagerMarketerEmail(); // MGRMRKT
		} elseif ($eventName == Event::EVENT_COMMENT) {
			/* TODO */
		} elseif ($eventName == Event::EVENT_FEE_MANAGEMENT) {
			$emails =	[$this->transform->getCreatorEmail()]; // CREA
		} elseif ($eventName == Event::EVENT_REJECT) {
			$emails = array_merge(
				$this->query->getByRole(Role::VERKEU), // VERKEU
				$this->query->getByRole(Role::KEU), // KEU
				$this->query->getByRole(Role::QAQC) // QAQC
			);
			$emails[] =	$this->transform->getManagerMarketerEmail(); // MGRMRKT
		}

		return $emails;
	}
}
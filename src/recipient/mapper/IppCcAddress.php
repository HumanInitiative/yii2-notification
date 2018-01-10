<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\Role;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppCcAddress implements RecipientAddressInterface
{
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
			$emails = $query->getByRole(Role::KEU); // KEU
			$emails[] =	$transform->getCreatorEmail(); // CREA
			$emails[] =	$transform->getMarketerEmail(); // MRKT
			$emails[] =	$transform->getManagerMarketerEmail(); // MGRMRKT
		} elseif ($eventName == Event::EVENT_APPROVE_KEU) {
			$emails = array_merge(
				$query->getByRole(Role::PDG), // PDG
				$query->getByRole(Role::QAQC), // QAQC
				$query->getByRole(Role::VERKEU) // VERKEU
			);
			$emails[] =	$transform->getMarketerEmail(); // MRKT
			$emails[] =	$transform->getManagerMarketerEmail(); // MGRMRKT
		} elseif ($eventName == Event::EVENT_COMMENT) {
			/* TODO */
		} elseif ($eventName == Event::EVENT_FEE_MANAGEMENT) {
			$emails =	[$transform->getCreatorEmail()]; // CREA
		} elseif ($eventName == Event::EVENT_REJECT) {
			$emails = array_merge(
				$query->getByRole(Role::VERKEU), // VERKEU
				$query->getByRole(Role::KEU), // KEU
				$query->getByRole(Role::QAQC) // QAQC
			);
			$emails[] =	$transform->getManagerMarketerEmail(); // MGRMRKT
		}

		return $emails;
	}
}
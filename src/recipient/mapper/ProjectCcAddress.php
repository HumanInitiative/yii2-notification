<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\ProjectActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\recipient\Role;
use pkpudev\notification\transform\DataTransformInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectCcAddress implements RecipientAddressInterface
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
	 * @var int $pusat
	 */
	private $pusat = 1;

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
		$eventIsRamadhan = $this->event->getIsRamadhan();
		$emails = [];

		if ($eventName == Event::EVENT_CREATE) {
			// If Ramadhan Then RMD
			if ($eventIsRamadhan) {
				$emails = $this->query->getByRole(Role::RMD);
			}
		} elseif ($eventName == Event::EVENT_VERIFY_QC) {
			// If Ramadhan Then RMD
			if ($eventIsRamadhan) {
				$emails = $this->query->getByRole(Role::RMD);
			}
		} elseif ($eventName == Event::EVENT_VERIFY_RMD) {
			$emails = $this->query->getByRole(Role::QAQC); // QAQC
		} elseif ($eventName == Event::EVENT_COMMENT) {
			/* TODO */
		} elseif ($eventName == Event::EVENT_RUNNING) {
			$emails = array_merge(
				$this->query->getByRole(Role::PDG), // PDG
				$this->query->getByRole(Role::QAQC), // QAQC
				$this->query->getByRole(Role::KEU) // KEU
			);
			$emails[] = $this->transform->getMarketerEmail(); // MRKT
		} elseif ($eventName == Event::EVENT_FINISHING) {
			$emails = array_merge(
				$this->query->getByRole(Role::PDG), // PDG
				$this->query->getByRole(Role::QAQC), // QAQC
				$this->query->getByRole(Role::KEU) // KEU
			);
			$emails[] = $this->transform->getMarketerEmail(); // MRKT
		} elseif ($eventName == Event::EVENT_VERIFYFINISH) {
			$emails = array_merge(
				$this->query->getByRole(Role::PDG), // PDG
				$this->query->getByRole(Role::QAQC) // QAQC
			);
			$emails[] = $this->transform->getMarketerEmail(); // MRKT
		} elseif ($eventName == Event::EVENT_ALERT_EXECDATE) {
			$emails = array_merge(
				$this->query->getByRole(Role::PDG), // PDG
				$this->query->getByRole(Role::QAQC), // QAQC
				$this->query->getByRole(Role::KEU) // KEU
			);
			$emails[] = $this->transform->getMarketerEmail(); // MRKT
		} elseif ($eventName == Event::EVENT_UPLOAD_REPORT) {
			// 
		}

		return $emails;
	}
}
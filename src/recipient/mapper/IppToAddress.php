<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppToAddress implements RecipientAddressInterface
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
	 * @var int $pusat
	 */
	private $pusat = 1;

	/**
	 * @inheritdoc
	 */
	public function __construct(RecipientQuery $query, ModelEventInterface $event)
	{
		$this->query = $query;
		$this->event = $event;
	}

	/**
	 * @inheritdoc
	 */
	public function getAll()
	{
		$eventName = $this->event->name;
		$eventBranchId = $this->query->branchId;
		$eventIsFromIzi = $this->event->isFromIzi;

		if ($eventName == Event::EVENT_CREATE) {
			if ($eventBranchId == $this->pusat) {
				if ($eventIsFromIzi) {
					// PIC
					// CREA
					// VERKEU
				} else {
					// QAQC
					// VERKEU
				}
			} else {
				// toEmailFromBranch
				if ($this->event->companyId) {
					// QAQC
				}
			}
		} elseif ($eventName == Event::EVENT_APPROVE_KEU) {
			if ($eventBranchId == $this->pusat) {
				// PIC
			} else {
				// toEmailFromBranch
			}
		} elseif ($eventName == Event::EVENT_COMMENT) {
			/* TODO */
		} elseif ($eventName == Event::EVENT_FEE_MANAGEMENT) {
			// QAQC
		} elseif ($eventName == Event::EVENT_REJECT) {
			if ($eventBranchId == $this->pusat) {
				// CREA
				// MRKT
			} else {
				// toEmailFromBranch
			}
		}
	}
}
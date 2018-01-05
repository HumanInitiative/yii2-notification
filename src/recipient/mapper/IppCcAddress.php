<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\IppActionEvent as Event;
use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;

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
		if ($eventName == Event::EVENT_CREATE) {
			// CREA
			// MRKT
			// MGRMRKT
			// KEU
		} elseif ($eventName == Event::EVENT_APPROVE_KEU) {
			// MRKT
			// MGRMRKT
			// PDG
			// QAQC
			// VERKEU
		} elseif ($eventName == Event::EVENT_COMMENT) {
			/* TODO */
		} elseif ($eventName == Event::EVENT_FEE_MANAGEMENT) {
			// CREA
		} elseif ($eventName == Event::EVENT_REJECT) {
			// MGRMRKT
			// VERKEU
			// KEU
			// QAQC
		}
	}
}
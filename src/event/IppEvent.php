<?php

namespace pkpudev\notification\event;

use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;
use IppActionEvent as Event;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppEvent extends ModelEvent implements ModelEventInterface
{
	private $id;
	private $status_id;

	public function __construct(ActiveRecordInterface $ipp)
	{
		$this->id = $ipp->id;
		$this->status_id = $ipp->status_id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getStatusId()
	{
		return $this->status_id;
	}

	public function getEventDesc()
	{
		if ($this->name == Event::EVENT_CREATE) {
			return "telah dibuat";
		} elseif ($this->name == Event::EVENT_APPROVE_KEU) {
			return "di-APPROVE Keuangan";
		} elseif ($this->name == Event::EVENT_FEE_MANAGEMENT) {
			return "Fee Management";
		} elseif ($this->name == Event::EVENT_REJECT) {
			return "DITOLAK oleh Keuangan";
		}
	}
}
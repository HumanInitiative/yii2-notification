<?php

namespace pkpudev\notification\event;

use IppActionEvent as Event;
use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppEvent extends ModelEvent implements ModelEventInterface
{
	private $id;
	private $status_id;
	private $company_id;
	private $fund_driven_id;
	private $from_izi;

	public function __construct(ActiveRecordInterface $ipp)
	{
		$this->id = $ipp->id;
		$this->status_id = $ipp->status_id;
		$this->company_id = $ipp->company_id;
		$this->fund_driven_id = $ipp->fund_driven_id;
		$this->from_izi = $ipp->from_izi;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getStatusId()
	{
		return $this->status_id;
	}

	public function getIsFromIzi()
	{
		return (
			$this->from_izi == 1 || 
			(
				$this->company_id == 2 && /* IZI */
			 	$this->fund_driven_id == 2 /* RKAT */
			)
		);
	}

	public function getCompanyId()
	{
		return $this->company_id;
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
		} elseif ($this->name == Event::EVENT_COMMENT) {
			return "Komentar terbaru";
		}
	}

	public function getEventFile()
	{
		if ($this->name == Event::EVENT_CREATE) {
			return "ipp-create";
		} elseif ($this->name == Event::EVENT_APPROVE_KEU) {
			return "ipp-approve";
		} elseif ($this->name == Event::EVENT_FEE_MANAGEMENT) {
			return "ipp-feemgmt";
		} elseif ($this->name == Event::EVENT_REJECT) {
			return "ipp-reject";
		} elseif ($this->name == Event::EVENT_COMMENT) {
			return "ipp-comment";
		}
	}
}
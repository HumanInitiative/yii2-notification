<?php

namespace pkpudev\notification\event;

use ProjectActionEvent as Event;
use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectEvent extends ModelEvent implements ModelEventInterface
{
	private $id;
	private $status_id;
	private $execdate_start;
	private $is_ramadhan;

	public function __construct(ActiveRecordInterface $project)
	{
		$this->id = $project->id;
		$this->status_id = $project->status_id;
		$this->execdate_start = date("d-m-Y", strtotime($project->realize_date_start));
		$this->is_ramadhan = $project->getIsRamadhan();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getStatusId()
	{
		return $this->status_id;
	}

	public function getIsRamadhan()
	{
		return $this->is_ramadhan;
	}

	public function getEventDesc()
	{
		if ($this->name == Event::EVENT_CREATE) {
			return "telah dibuat";
		} elseif ($this->name == Event::EVENT_VERIFY_QC) {
			return "telah diverifikasi";
		} elseif ($this->name == Event::EVENT_VERIFY_RMD) {
			return "telah diverifikasi";
		} elseif ($this->name == Event::EVENT_COMMENT) {
			return "Komentar terbaru";
		} elseif ($this->name == Event::EVENT_RUNNING) {
			return "telah berjalan";
		} elseif ($this->name == Event::EVENT_FINISHING) {
			return "telah selesai";
		} elseif ($this->name == Event::EVENT_VERIFYFINISH) {
			return "telah diverifikasi dan dinyatakan Finish";
		} elseif ($this->name == Event::EVENT_ALERT_EXECDATE) {
			return "akan dieksekusi tanggal {$this->execdate_start}";
		} elseif ($this->name == Event::EVENT_UPLOAD_REPORT) {
			return " - Laporan telah diupload";
		}
	}

	public function getEventFile()
	{
		if ($this->name == Event::EVENT_CREATE) {
			return "project-create";
		} elseif ($this->name == Event::EVENT_VERIFY_QC) {
			return "project-verify-qaqc";
		} elseif ($this->name == Event::EVENT_VERIFY_RMD) {
			return "project-verify-ramadhan";
		} elseif ($this->name == Event::EVENT_COMMENT) {
			return "project-comment";
		} elseif ($this->name == Event::EVENT_RUNNING) {
			return "project-running";
		} elseif ($this->name == Event::EVENT_FINISHING) {
			return "project-finishing";
		} elseif ($this->name == Event::EVENT_VERIFYFINISH) {
			return "project-verify-finish";
		} elseif ($this->name == Event::EVENT_ALERT_EXECDATE) {
			return "project-alert-execdate";
		} elseif ($this->name == Event::EVENT_UPLOAD_REPORT) {
			return "project-report-upload";
		}
	}
}
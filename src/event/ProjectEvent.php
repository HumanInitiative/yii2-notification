<?php

namespace pkpudev\notification\event;

use yii\base\ModelEvent;
use yii\db\ActiveRecordInterface;
use ProjectActionEvent as Event;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectEvent extends ModelEvent implements ModelEventInterface
{
	private $id;
	private $status_id;

	public function __construct(ActiveRecordInterface $project)
	{
		$this->id = $project->id;
		$this->status_id = $project->status_id;
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
		} elseif ($this->name == Event::EVENT_VERIFY_QC) {
			return "telah diverifikasi";
		} elseif ($this->name == Event::EVENT_VERIFY_RMD) {
			return "telah diverifikasi";
		} elseif ($this->name == Event::EVENT_RUNNING) {
			return "telah berjalan";
		} elseif ($this->name == Event::EVENT_FINISHING) {
			return "telah selesai";
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
		} elseif ($this->name == Event::EVENT_RUNNING) {
			return "project-running";
		} elseif ($this->name == Event::EVENT_FINISHING) {
			return "project-finishing";
		}
	}
}
<?php

namespace pkpudev\notification\transform;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProjectTransform implements DataTransformInterface
{
	use AccessorTrait;
	
	/**
	 * @var Project
	 */
	private $model;

	/**
	 * @inheritdoc
	 */
	public function __construct(ActiveRecordInterface $model)
	{
		$this->model = $model;
		$this->program = $model->program;
		$this->creator = $model->creator;
	}
	/**
	 * @inheritdoc
	 */
	public function getParams()
	{
		$object = new stdClass;
		$object->id           = $this->model->id;
		$object->no           = $this->model->project_no;
		$object->name         = $this->model->project_name;
		$object->project_date = date("d-m-Y", strtotime($this->model->project_date));
		$object->exec_date    = date("d-m-Y", strtotime($this->model->realize_date_start));
		$object->program      = $this->model->program ? $this->model->project_name : "-";
		$object->pic          = $this->model->pic ? $this->model->pic->full_name : "-";
		$object->creator      = $this->model->creator ? $this->model->creator->full_name : "-";
		$object->verifikator  = $this->model->verificator ? $this->model->verificator->full_name : "-";
		$object->location     = $this->model->getLocation();
		$object->last_file    = $this->model->lastUploadedFile ? $this->model->lastUploadedFile->file : null;
		$object->year         = date('Y', strtotime($this->model->project_date));
		$object->is_ramadhan  = $this->model->isRamadhan;
		// mitra = $model->cpm ? $model->cpm->partner->partner_name : "-",
		return $object;
	}
	/**
	 * @inheritdoc
	 */
	public function getModel()
	{
		return $this->model;
	}
}
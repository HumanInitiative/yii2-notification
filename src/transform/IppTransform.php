<?php

namespace pkpudev\notification\transform;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppTransform implements DataTransformInterface
{
	use AccessorTrait;

	/**
	 * @var Ipp
	 */
	private $model;
	/**
	 * @var object
	 */
	private $params;

	/**
	 * @inheritdoc
	 */
	public function __construct(ActiveRecordInterface $model)
	{
		$this->model = $model;
		$this->program = $model->program;
		$this->creator = $model->creator;
		$this->marketer = $model->marketer;
	}
	/**
	 * @inheritdoc
	 */
	public function getParams()
	{
		if (!is_null($this->params)) {
			return $this->params;
		}

		$object = new stdClass;
		$object->id          = $this->model->id;
		$object->title       = $this->model->program_name;
		$object->no          = $this->model->ipp_no;
		$object->ipp_date    = date_format(date_create($this->model->ipp_date), "d-m-Y");
		$object->exec_date   = $this->model->getExecutionDate("d-m-Y");
		$object->program     = $this->model->program_id ? $this->model->program_name : "-";
		$object->amount      = $this->getAmount();
		$object->donatur     = $this->model->donor_id ? $this->model->donatur->text : "-";
		$object->marketer    = $this->model->marketer_id ? $this->model->marketer->name : "-";
		$object->creator     = $this->model->created_by ? $this->model->creator->name : "-";
		$object->approver    = $this->model->approved_by ? $this->model->approver->name : "-";
		$object->location    = $this->model->getLocation();
		$object->company     = $this->model->company_id;
		$object->year        = date('Y', strtotime($this->model->ipp_date));
		$object->is_ramadhan = $this->model->isRamadhan;

		return $this->params = $object;
	}
	/**
	 * @inheritdoc
	 */
	public function getModel()
	{
		return $this->model;
	}
	/**
	 * Get formatted total amount of Ipp
	 *
	 * @return string
	 */
	protected function getAmount()
	{
		if ($total_amount = $this->model->total_amount) {
			$symbol = $this->model->getCurrencyCode('symbol');
			$amount = number_format($total_amount, 0, ',', '.');
			return sprintf('%s. %s', $symbol, $amount);
		}
		return "-";
	}
}
<?php

namespace pkpudev\notification\transform;

use yii\db\ActiveRecordInterface;

class IppTransform implements DataTransformInterface
{
	/**
	 * @var Ipp
	 */
	private $ipp;

	/**
	 * @inheritdoc
	 */
	public function __construct(ActiveRecordInterface $model)
	{
		
	}
	/**
	 * @inheritdoc
	 */
	public function getParams()
	{
		return [];
	}
	/**
	 * Get PIC (Person in charge) Email
	 * @return Recipient[]
	 */
	public function getPicEmail()
	{
		return [];
	}
	/**
	 * Get Creator Email
	 * @return Recipient[]
	 */
	public function getCreatorEmail()
	{
		return [];
	}
	/**
	 * Get Marketer Email
	 * @return Recipient[]
	 */
	public function getMarketerEmail()
	{
		return [];
	}
	/**
	 * Get Manager Marketer Email
	 * @return Recipient[]
	 */
	public function getManagerMarketerEmail()
	{
		return [];
	}
}
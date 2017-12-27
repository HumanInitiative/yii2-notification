<?php

namespace pkpudev\notification\transform;

use yii\db\ActiveRecordInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class IppCommentTransform implements DataTransformInterface
{
	use AccessorTrait;

	/**
	 * @var IppComment
	 */
	private $model;
	/**
	 * @var Comment
	 */
	private $comment;

	/**
	 * @inheritdoc
	 */
	public function __construct(ActiveRecordInterface $model)
	{
		$this->model = $model;
	}
	/**
	 * @inheritdoc
	 */
	public function getParams()
	{
		return new stdClass;
	}
	/**
	 * @inheritdoc
	 */
	public function getModel()
	{
		return $this->model;
	}
	/**
	 * @return Comment
	 */
	public function getComment()
	{
		return $this->comment;
	}
}
<?php

namespace pkpudev\notification\transform;

use pkpudev\notification\recipient\Factory;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
trait AccessorTrait
{
	/**
	 * @var ActiveRecordInterface $program
	 */
	protected $program;
	/**
	 * @var ActiveRecordInterface $creator
	 */
	protected $creator;
	/**
	 * @var ActiveRecordInterface $marketer
	 */
	protected $marketer;

	/**
	 * Get PIC (Person in charge) Email
	 * @return Recipient
	 */
	public function getPicEmail()
	{
		if ($this->program && ($pic = $this->program->pic)) {
			return Factory::fromEmployee($pic);
		}
	}
	/**
	 * Get Creator Email
	 * @return Recipient
	 */
	public function getCreatorEmail()
	{
		if ($this->creator) {
			return Factory::fromEmployee($this->creator);
		}
	}
	/**
	 * Get Marketer Email
	 * @return Recipient
	 */
	public function getMarketerEmail()
	{
		if ($this->marketer) {
			return Factory::fromEmployee($this->marketer);
		}
	}
	/**
	 * Get Manager Marketer Email
	 * @return Recipient
	 */
	public function getManagerMarketerEmail()
	{
		if ($this->marketer && ($manager = $this->marketer->manager)) {
			return Factory::fromEmployee($this->manager);
		}
	}
}
<?php

namespace pkpudev\notification\recipient;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ModelName
{
	const ALL = 'All';
	const IPP = 'Ipp';
	const PROJECT = 'Project';
	const PROPOSAL = 'Proposal';

	/**
	 * @var string $name
	 */
	protected $name;

	/**
	 * Class constructor
	 * 
	 * @param string $name
	 */
	public function __construct($name)
	{
		if (!in_array($name, ['All', 'Ipp', 'Project', 'Proposal']))
			throw new yii\base\InvalidConfigException('Invalid model name for Query');

		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
}
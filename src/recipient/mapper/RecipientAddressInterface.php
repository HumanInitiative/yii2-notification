<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\RecipientQuery;
use pkpudev\notification\transform\DataTransformInterface;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
interface RecipientAddressInterface
{
	/**
	 * Class constructor
	 * 
	 * @param RecipientQuery $query
	 * @param ModelEventInterface $event
	 */
	public function __construct(
		DataTransformInterface $transform,
		RecipientQuery $query,
		ModelEventInterface $event
	);
	/**
	 * @return Recipient[];
	 */
	public function getAll();
}
<?php

namespace pkpudev\notification\recipient\mapper;

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
	public function __construct(RecipientQuery $query, ModelEventInterface $event);
	/**
	 * @return Recipient[];
	 */
	public function getAll();
}
<?php

namespace pkpudev\notification\recipient\mapper;

use pkpudev\notification\event\ModelEventInterface;
use pkpudev\notification\recipient\ModelName;
use pkpudev\notification\recipient\RecipientQuery;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class Mapper
{
	const ADDRESSTYPE_TO = 'to';
	const ADDRESSTYPE_CC = 'cc';

	/**
	 * Create Recipient Address
	 * 
	 * @param RecipientQuery $query
	 * @param ModelEventInterface $event
	 * @param int $addressType
	 */
	public static function create(RecipientQuery $query, ModelEventInterface $event, $addressType)
	{
		$isModelIpp = $query->modelName->getName() == ModelName::IPP;
		$isModelProject = $query->modelName->getName() == ModelName::PROJECT;

		if ($addressType == static::ADDRESSTYPE_TO) {
			if ($isModelIpp) {
				return new IppToAddress($query, $event);
			} elseif ($isModelProject) {
				return new ProjectToAddress($query, $event);
			} else {
				throw new yii\base\InvalidConfigException("Invalid modelName for RecipientAddress to");
			}
		} elseif ($addressType == static::ADDRESSTYPE_CC) {
			if ($isModelIpp) {
				return new IppCcAddress($query, $event);
			} elseif ($isModelProject) {
				return new ProjectCcAddress($query, $event);
			} else {
				throw new yii\base\InvalidConfigException("Invalid modelName for RecipientAddress cc");
			}
		} else {
			throw new yii\base\InvalidConfigException("Invalid addressType for RecipientAddress");
		}
	}
}
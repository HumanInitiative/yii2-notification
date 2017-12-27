<?php

namespace pkpudev\notification;

/**
 * @author Zein Miftah <zeinmiftah@gmail.com>
 */
class ProgramHelper
{
	/**
	 * Either Ramadhan / Project
	 *
	 * @param bool $isRamadhan
	 * @param int $year
	 * @return string
	 */
	public static function titlePrefix($isRamadhan, $year=null)
	{
		$year = $year ?: date('Y');
		$hijri = $year - 579;
		return $isRamadhan ? "[RMD-{$hijri}H]" : "[Proyek-{$year}]";
	}
}
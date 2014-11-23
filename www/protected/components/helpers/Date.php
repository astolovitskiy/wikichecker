<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 07.06.13
 * Time: 14:16
 * To change this template use File | Settings | File Templates.
 */

class Date {

	const FORMAT_DB = "Y-m-d H:i:s";
	const FORMAT_DB_SHORT = "Y-m-d";

	const DEFAULT_START_YEAR = 1940;

	const NULL_VALUE = '--';

	const SECONDS_IN_MINUTE = 60;
	const SECONDS_IN_HOUR = 3600;
	const SECONDS_IN_DAY = 86400;
	const SECONDS_IN_WEEK = 604800;
	const SECONDS_IN_MONTH = 2629744;
	const SECONDS_IN_YEAR = 31556926;

	/**
	 * @param bool $null
	 * @return array
	 */
	public static function getMinutes($null = TRUE) {
		$minutes = array();
		($null) ? $minutes[NULL] = self::NULL_VALUE : TRUE;
		for($i = 0; $i <= 5; $i++)
			$minutes[$i.'0'] = $i.'0';

		return $minutes;
	}

	/**
	 * @var $date string
	 * @return string
	 */
	public static function toShortDate($date) {
		return date(Date::FORMAT_DB_SHORT, strtotime($date));
	}

	/**
	 * @param bool $null
	 * @return array
	 */
	public static function getHours($null = TRUE) {
		$hours = array();
		($null) ? $hours[NULL] = self::NULL_VALUE : TRUE;
		for($i = 1; $i <= 24; $i++)
			$hours[$i] = $i;

		return $hours;
	}

	/**
	 * @param bool $null
	 * @return array
	 */
	public static function getDays($null = TRUE) {
		$days = array();
		($null) ? $days[NULL] = self::NULL_VALUE : TRUE;
		for($i = 1; $i <= 31; $i++)
			$days[$i] = $i;

		return $days;
	}

	/**
	 * @param bool $null
	 * @return array
	 */
	public static function getMonths($null = TRUE) {
		$months = array();
		($null) ? $months[NULL] = self::NULL_VALUE : TRUE;
		for($i = 1; $i <= 12; $i++)
			$months[$i] = $i;

		return $months;
	}


	/**
	 * @param bool $null
	 * @param bool|int $start
	 * @param bool|int $end
	 * @return array
	 */
	public static function getYears($null = TRUE, $start = FALSE, $end = FALSE) {
		$years = array();
		($null) ? $years[NULL] = self::NULL_VALUE : true;
		$start = ($start) ? $start : self::DEFAULT_START_YEAR;
		$end = ($end) ? $end : date('Y');
		for($i = $end; $i >= $start; $i--)
			$years[$i] = $i;

		return $years;
	}

	/**
	 * @param $date int
	 * @return string
	 */
	public static function getTimePassed($date) {
		$timeLost = (time() - strtotime($date));

		if(($timeLost / Date::SECONDS_IN_MINUTE) < 1)
			return 'менее минуты';

		if(($timeLost / Date::SECONDS_IN_MINUTE) < 60)
			return floor($timeLost / self::SECONDS_IN_MINUTE).' мину'.Text::declensionNumeral($timeLost / self::DATE_MINUTE, array('а', 'ты', 'т'));

		if(($timeLost / Date::SECONDS_IN_HOUR) < 60)
			return floor($timeLost / Date::SECONDS_IN_HOUR).' час'.Text::declensionNumeral($timeLost / self::DATE_HOUR, array('', 'а', 'ов'));

		$days = floor($timeLost / (Date::SECONDS_IN_DAY));

		return $days.' д'.Text::declensionNumeral($days, array('ень', 'ня', 'ней'));
	}

	/**
	 * @param $from string
	 * @param $to string
	 * @param string $format
	 * @return array
	 */
	public static function getDates($from, $to, $format = Date::FORMAT_DB_SHORT) {
		$dates = array();

		for($time = strtotime($from); $time <= strtotime($to); $time += Date::SECONDS_IN_DAY)
			$dates[] = date($format, $time);

		if($dates[(count($dates) - 1)] != date($format, strtotime($to)))
			$dates[] = date($format, $time);

		return $dates;
	}
}
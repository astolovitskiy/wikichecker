<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 15:12
 * To change this template use File | Settings | File Templates.
 */

class FilterDateInterval extends FilterInterval {

	/**
	 * @var string
	 */
	protected  $_view = 'filterDateInterval';

	/**
	 * @return array
	 */
	protected function getParams() {
		return array(
			'valueFrom' => $this->formatDate(Yii::app()->request->getParam('from_'.$this->_attribute)),
			'valueTo' => $this->formatDate(Yii::app()->request->getParam('to_'.$this->_attribute))
		);
	}

	/**
	 * @param $date string|null
	 * @return bool|string
	 */
	private function formatDate($date) {
		if( ! $date)
			return FALSE;
		return date(Date::FORMAT_DB, strtotime($date));
	}
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 06.08.13
 * Time: 10:34
 */

class FilterInterval extends Filter {

	/**
	 * @param ActiveRecord $items
	 * @return ActiveRecord|void
	 */
	public function addFilter($items) {
		$params = $this->getParams();
		$valueFrom = Arr::get($params, 'valueFrom', FALSE);
		$valueTo = Arr::get($params, 'valueTo', FALSE);

		if($valueFrom) $items->getDbCriteria()->mergeWith($this->getFromCriteria($valueFrom));
		if($valueTo) $items->getDbCriteria()->mergeWith($this->getToCriteria($valueTo));

		return $items;
	}

	/**
	 * @return array
	 */
	protected function getParams() {
		return array(
			'valueFrom' => Yii::app()->request->getParam('from_'.$this->_attribute),
			'valueTo' => Yii::app()->request->getParam('to_'.$this->_attribute)
		);
	}

	/**
	 * @param $value
	 * @return array|string
	 */
	protected function getFromCriteria($value) {
		return array(
			'condition' => ' `t`.`'.$this->_attribute.'` >= :valueFrom',
			'params' => array(':valueFrom' => $value)
		);
	}

	/**
	 * @param $value
	 * @return array|string
	 */
	protected function getToCriteria($value) {
		return array(
			'condition' => ' `t`.`'.$this->_attribute.'` <= :valueTo',
			'params' => array(':valueTo' => $value)
		);
	}
}
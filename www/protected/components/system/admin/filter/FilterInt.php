<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 15:12
 * To change this template use File | Settings | File Templates.
 */

class FilterInt extends Filter {

	/**
	 * @var string
	 */
	protected  $_view = 'filterInt';

	/**
	 * @param ActiveRecord $items
	 * @return array|void
	 */
	public function addFilter($items) {
		$value = $this->getValue();

		if($value && is_numeric($value))
			$items->getDbCriteria()->mergeWith(array(
				'condition' => ' `t`.`'.$this->_attribute.'` = :value',
				'params' => array(':value' => (int) $value)
			));

		return $items;
	}
}
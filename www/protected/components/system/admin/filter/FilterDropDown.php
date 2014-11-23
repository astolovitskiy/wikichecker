<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 10/25/13
 * Time: 4:46 PM
 * To change this template use File | Settings | File Templates.
 */

class FilterDropDown extends Filter {

	/**
	 * @var string
	 */
	protected  $_view = 'filterDropDown';

	/**
	 * @param ActiveRecord $items
	 * @return array|void
	 */
	public function addFilter($items) {
		$value = $this->getValue();

		if($value)
			$items->getDbCriteria()->mergeWith(array(
				'condition' => ' `t`.`'.$this->_attribute.'` = :value',
				'params' => array(':value' => $value)
			));

		return $items;
	}
}
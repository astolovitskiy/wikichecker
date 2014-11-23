<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 15:12
 * To change this template use File | Settings | File Templates.
 */

class FilterString extends Filter {

	/**
	 * @var string
	 */
	protected  $_view = 'filterString';

	/**
	 * @param ActiveRecord $items
	 * @return array|void
	 */
	public function addFilter($items) {
		$value = $this->getValue();

		if($value)
			$items->getDbCriteria()->mergeWith(array(
				'condition' => ' `t`.`'.$this->_attribute.'` LIKE \'%'.$value.'%\' ',
			));

		return $items;
	}
}
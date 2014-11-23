<?php
/**
 * Created by JetBrains PhpStorm.
 * User: UnderDark
 * Date: 29.07.13
 * Time: 15:57
 * To change this template use File | Settings | File Templates.
 */

abstract class Filter {

	/**
	 * @var string
	 */
	protected $_viewPath = '//crud/filter/';

	/**
	 * @var string
	 */
	protected $_view = '';

	/**
	 * @var string
	 */
	protected $_attribute;

	/**
	 * @var array
	 */
	protected $_options;

	/**
	 * @var ActiveRecord
	 */
	protected $_model;

	/**
	 * @param $attributes string
	 * @param $options array
	 * @param $model ActiveRecord
	 */
	public function __construct($attributes, $options, $model) {
		$this->_attribute = $attributes;
		$this->_options = $options;
		$this->_model = new $model;
	}

	/**
	 * @param ActiveRecord $items
	 * @return ActiveRecord
	 */
	abstract public function addFilter($items);

	/**
	 * void
	 */
	public function render() {
		Yii::app()->controller->renderPartial($this->_viewPath.$this->_view, array('attribute' => $this->_attribute, 'options' => $this->_options, 'model' => $this->_model));
	}

	/**
	 * @return string
	 */
	protected function getValue() {
		return Yii::app()->request->getParam($this->_attribute);
	}
}
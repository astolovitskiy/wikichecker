<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 17:54
 */

abstract class GridColumn {

	/**
	 * @var string
	 */
	protected $_column;

	/**
	 * @var ActiveRecord
	 */
	protected $_item;

	/**
	 * @var array | string
	 */
	protected $_type;

	/**
	 * @param ActiveRecord $item
	 * @param $column
	 * @param $type
	 * @return GridColumn
	 */
	public static function factory(ActiveRecord $item, $column, $type) {
		if(is_array($type))
			$typeName = $type['type'];
		else
			$typeName = $type;

		$className = 'GridColumn'.ucfirst($typeName);

		return new $className($item, $column, $type);
	}

	/**
	 * @param $item
	 * @param $column
	 * @param $type
	 */
	private function __construct($item, $column, $type) {
		$this->setItem($item);
		$this->setColumn($column);
		$this->setType($type);
	}

	abstract function render();

	/**
	 * @return array|null|string
	 */
	public function getColumn() {
		return $this->_column;
	}

	/**
	 * @param $column
	 */
	public function setColumn($column) {
		$this->_column = $column;
	}

	/**
	 * @param $item
	 */
	public function setItem($item) {
		$this->_item = $item;
	}

	/**
	 * @return ActiveRecord
	 */
	public function getItem() {
		return $this->_item;
	}

	/**
	 * @param $type
	 */
	public function setType($type) {
		$this->_type = $type;
	}

	/**
	 * @return array|string
	 */
	public function getType() {
		return $this->_type;
	}
}


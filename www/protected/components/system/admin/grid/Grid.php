<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 16:42
 */

class Grid {

	/**
	 * @var string
	 */
	const INDEX_VIEW_PATH = '//crud/grid/index';

	/**
	 * @var string
	 */
	const HEAD_VIEW_PATH = '//crud/grid/head';

	/**
	 * @var string
	 */
	const ITEMS_VIEW_PATH = '//crud/grid/items';

	/**
	 * @var string
	 */
	const PAGINATION_VIEW_PATH = '//crud/grid/pagination';

	/**
	 * @var ActiveRecord
	 */
	private $_model;

	/**
	 * @var ActiveRecord
	 */
	private $_items;

	/**
	 * @var int
	 */
	private $_limit;

	/**
	 * @var int
	 */
	private $_itemsCount;

	/**
	 * @param ActiveRecord $model
	 * @param ActiveRecord $items
	 * @param $limit
	 */
	public function __construct(ActiveRecord $model, ActiveRecord $items, $limit) {
		$this->_model = $model;
		$this->_items = $items;
		$this->_limit = $limit;
		$cloneItems = clone $items;
		$this->_itemsCount = $cloneItems->count();
	}

	/**
	 * @return mixed
	 */
	public function render() {
		return Yii::app()->controller->renderPartial(self::INDEX_VIEW_PATH, array('grid' => $this));
	}

	/**
	 * @return array
	 */
	public function getHeader() {
		$columns = $this->_model->gridColumns();
		$labels = $this->_model->attributeLabels();
		$header = array();

		foreach($columns as $columnName => $type) {
			$header[] = isset($labels[$columnName]) ? $labels[$columnName] : $columnName;
		}

		return $header;
	}

	/**
	 * @param $name string
	 * @return null|string
	 */
	public function getHeaderClass($name) {
		$labels = $this->_model->attributeLabels();
		$columns = $this->_model->gridColumns();

		$label = array_search($name, $labels);
		return Arr::get(Arr::get($columns, $label, array()), 'class');
	}

	/**
	 * @return array
	 */
	public function getColumns() {
		return $this->_model->gridColumns();
	}

	/**
	 * @return ActiveRecord
	 */
	public function getItems() {
		return $this->_items;
	}

	/**
	 * @return int|string
	 */
	public function getItemsCount() {
		return $this->_itemsCount;
	}

	/**
	 * @return mixed
	 */
	public function getPages() {
		$pages = Yii::app()->controller->getPages($this->getItemsCount(), $this->_limit);
		return $pages;
	}

	/**
	 * @return int
	 */
	public function getLimit() {
		return $this->_limit;
	}

	/**
	 * @return ActiveRecord
	 */
	public function getModel() {
		return $this->_model;
	}
}

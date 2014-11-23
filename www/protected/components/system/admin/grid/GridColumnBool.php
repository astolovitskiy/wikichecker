<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 18:37
 */

class GridColumnBool extends GridColumn {

	/**
	 * @var string
	 */
	const VIEW_PATH = '//crud/grid/columns/bool';

	/**
	 * @return mixed
	 */
	public function render() {
		return Yii::app()->controller->renderPartial(self::VIEW_PATH, array('gridColumn' => $this));
	}
}

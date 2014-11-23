<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 18:01
 */

class GridColumnString extends GridColumn {

	/**
	 * @return string
	 */
	public function render() {
		return $this->getItem()->{$this->getColumn()};
	}
}


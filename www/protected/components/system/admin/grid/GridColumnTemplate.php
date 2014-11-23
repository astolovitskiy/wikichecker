<?php
/**
 * Created by JetBrains PhpStorm.
 * User: a.burkut Dem
 * Email : a.burkut90@gmail.com
 * Date: 23.05.13
 * Time: 18:04
 */

class GridColumnTemplate extends GridColumn {

	/**
	 * @return mixed
	 */
	public function render() {
		$type = $this->getType();
		preg_match_all('|\$\{(.*)\}|is', $type['template'], $matches);

		$result = $type['template'];
		foreach(Arr::get($matches, 1, array()) as $match) {
			$result = str_replace('${'.$match.'}', $this->getItem()->{$match}, $result);
		}

		return $result;
	}
}


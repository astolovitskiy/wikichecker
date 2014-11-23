<?php

class ActiveRecord extends CActiveRecord {

	private static $_events = array();
	protected $_labels = array();

	public function init() {
		$this->attachEvents($this->events());
	}

	public function attachEvents($events) {
		foreach (self::$_events as $event) {
			if ($event['component'] == get_class($this)) {
				parent::detachEventHandler($event['name'], $event['handler']);
				parent::attachEventHandler($event['name'], $event['handler']);
			}
		}
	}

	public function events() {
		return self::$_events;
	}

	public function attachStaticEventHandler($name, $handler) {
		self::$_events[] = array(
			'component' => get_class($this),
			'name' => $name,
			'handler' => $handler
		);

		parent::attachEventHandler($name, $handler);
	}

	public function detachEventHandler($name, $handler) {
		foreach (self::$_events as $index => $event) {
			if ($event['name'] == $name && $event['handler'] == $handler)
				unset(self::$_events[$index]);
		}
		return parent::detachEventHandler($name, $handler);
	}

	public function __get($name) {

		if (method_exists($this, 'get' . str_replace('_', '', $name)))
			return call_user_func(array($this, 'get' . str_replace('_', '', $name)));

		return parent::__get($name);
	}

	protected function getRawValue($name) {
		return parent::__get($name);
	}

	public function saveSlug($name) {
		$slug = $this->generateSlug($name);

		$c = new CDbCriteria();
		$c->compare('lower(slug)', $slug, true);
		$c->compare('id', '<>' . $this->id);
		$c->order = 'lower(slug)';

		$items = $this->findAll($c);

		$takenIndexes = array();
		$takenNonIndex = false;

		foreach ($items as $item) {
			preg_match('/.*?\-(?P<index>\d+)/', $item->slug, $matches);

			if (isset($matches['index'])) {
				$takenIndexes[] = $matches['index'];
			}

			if (strtolower($item->slug) == $slug) {
				$takenNonIndex = true;
			}
		}


		$index = 1;

		if ($takenNonIndex) {
			while (in_array($index, $takenIndexes)) {
				$index++;
			}
			$slug .= '-' . ($index);
		}

		$this->slug = $slug;
	}

	public function attributes($attributes = array()) {
		$this->attributes = $attributes;
		return $this;
	}

	public function isCorrectSlug($name) {
		$slug = $this->generateSlug($name);
		return preg_match('/' . $slug . '[\-]*\d*/', $this->slug);
	}

	public function generateSlug($name) {
		$slug = strtolower(Text::translit($name));
		$slug = preg_replace('/[^\\pL\d]+/u', '-', $slug);
		$slug = preg_replace('/[^-\w]+/', '', $slug);
		return $slug;
	}

	public function generateSlugString($name) {
		$slug = strtolower($name);
		$slug = html_entity_decode($slug, ENT_COMPAT, 'UTF-8');
		$slug = preg_replace('/([^\w\d]|[\s])+/is', '-', $slug);
		$slug = preg_replace('/^-*(.*?)-*$/', '$1', $slug);
		$slug = preg_replace("/[^a-z0-9\-]/", "", $slug);

		return $slug;
	}

	public function findBySlug($slug) {
		return $this->findByAttributes(array('slug' => $slug));
	}

	protected function beforeSave() {

		if ($this->isNewRecord && $this->hasAttribute('created_at')) {
			$this->created_at = date(Date::FORMAT_DB);
		}

		if ($this->hasAttribute('updated_at')) {
			$this->updated_at = date(Date::FORMAT_DB);
		}

		return parent::beforeSave();
	}

	public function setAttributes($values, $safeOnly = true) {
		if (!is_array($values))
			return;
		$attributes = array_flip($safeOnly ? $this->getSafeAttributeNames() : $this->attributeNames());
		foreach ($values as $name => $value) {
			if (isset($attributes[$name])) {
				if (is_string($value)) {
					$value = trim($value);
				}
				$this->$name = $value;
			} else if ($safeOnly) {
				$this->onUnsafeAttribute($name, $value);
			}
		}
		return $this;
	}

	public function findAndDeleteAll($condition = '', $params = array()) {
		$rows = $this->findAll($condition, $params);
		$this->_deleteBunchOfObjects($rows);
	}

	public function findAndDeleteAllByAttributes($attributes, $condition = '', $parrams = array()) {
		$rows = $this->findAllByAttributes($attributes, $condition, $parrams);
		$this->_deleteBunchOfObjects($rows);
	}

	public function findAndDeleteByPk($pk, $condition = '', $params = array()) {
		$rows = $this->findByPk($pk, $condition, $params);
		$this->_deleteBunchOfObjects($rows);
	}

	private function _deleteBunchOfObjects($rows) {
		foreach ($rows as $row) {
			$row->delete();
		}
	}

	public function onBeforeSave($event)
	{
		parent::onBeforeSave($event);
	}

	public function whereAttributes($attributes = array()) {
		foreach ($attributes as $attribute => $value) {
			$this->getDbCriteria(TRUE)->mergeWith(array(
				'condition' => ' "'.$attribute.'" = :value ',
				'params' => array(':value' => $value)
			));
		}

		return $this;
	}

	/**
	 * @param array $ids
	 * @return $this
	 */
	public function whereIdIn(array $ids) {
		$ids = "'".implode("','", $ids)."'";

		$this->getDbCriteria()->mergeWith(array(
			'condition' => 't.`id` IN ('.$ids.')',
			'order' => 'FIELD(t.id, '.$ids.') ASC'
		));

		return $this;
	}

	/**
	 * @param $limit
	 * @return ActiveRecord
	 */
	public function limit($limit) {
		$this->getDbCriteria()->mergeWith(array(
			'limit' => $limit,
		));
		return $this;
	}

	/**
	 * @param $offset
	 * @return ActiveRecord
	 */
	public function offset($offset) {
		$this->getDbCriteria()->mergeWith(array(
			'offset' => $offset,
		));
		return $this;
	}

	/**
	 * @param $raw
	 * @param $orderDirection
	 * @return ActiveRecord
	 */
	public function orderBy($raw, $orderDirection) {
		$this->getDbCriteria(TRUE)->mergeWith(array(
			'order' => sprintf('%s %s', $raw, $orderDirection)
		));
		return $this;
	}

	/**
	 * @param $raw
	 * @return $this
	 */
	public function group($raw) {
		$this->getDbCriteria()->mergeWith(array(
			'group' => $raw
		));

		return $this;
	}

	/**
	 * @param bool $isActive
	 * @return $this
	 */
	public function whereActive($isActive = TRUE) {
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 't.`is_active` = :is_active',
			'params' => array(':is_active' => $isActive)
		));

		return $this;
	}

	/**
	 * @param $items
	 * @param $idRow
	 * @param $nameRow
	 * @return array
	 */
	public static function getOptions($items, $idRow, $nameRow, $empty = FALSE, $defaultValue = '--выберите значение--') {
		if($empty) $results = array();
		else $results = array('' => $defaultValue);

		foreach ($items as $obj) {
			$results[$obj->{$idRow}] = $obj->{$nameRow};
		}

		return $results;
	}

	/**
	 * @return bool
	 */
	public function allowUpdate() {
		return TRUE;
	}

	/**
	 * @return bool
	 */
	public function allowDelete() {
		return TRUE;
	}

	/**
	 * @return string
	 */
	public function getEmailView() {
		return CHtml::mailto($this->email);
	}
}
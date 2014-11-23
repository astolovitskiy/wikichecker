<?php

class WebUser extends CWebUser {

	private $_model;
	private $id = NULL;
	public $roles = array();
	public $location;

	public function init() {
		$conf = Yii::app()->session->cookieParams;
		$this->identityCookie = array(
			'path' => $conf['path'],
			'domain' => $conf['domain'],
		);

		parent::init();
		$this->update();
	}

	/**
	 * @return string
	 */
	public function getRole() {
		$user = $this->_getModel();
		if ($user)
			return $user->role;
		return 'guest';
	}

	/**
	 * @return mixed
	 */
	private function _getModel() {
		if (!$this->getIsGuest() && ($this->_model === null)) {
			$this->_setModel($this->id);
		}
		return $this->_model;
	}

	/**
	 * @param $id
	 */
	private function _setModel($id) {
		$this->_model = new Page();
	}

	public function __get($name) {
		try {
			return parent::__get($name);
		} catch (CException $e) {
			$m = $this->_getModel();
			if($m->__isset($name))
				return $m->{$name};
			else throw $e;
		}
	}

	public function __set($name, $value) {
		try {
			return parent::__set($name, $value);
		} catch (CException $e) {
			$m = $this->_getModel();
			$m->{$name} = $value;
		}
	}

	public function update() {
		$this->_setModel($this->getId());
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		$user = $this->_getModel();
		if ($user && method_exists($user, $name)) {
			return call_user_func_array(array($user, $name), $arguments);
		}

		parent::__call($name, $arguments);
	}
}

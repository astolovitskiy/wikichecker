<?php

class InternalUserIdentity extends CUserIdentity {

	/**
	 * @var int
	 */
	private $_id;

	/**
	 * @var string
	 */
	public $user;

	/**
	 * @var int
	 */
	const ERROR_NOT_ACTIVE = 3;

	/**
	 * @var int
	 */
	const ERROR_CLOSED = 4;

	/**
	 * @param string $user
	 */
	public function __construct($user) {
		$this->user = $user;
	}

	/**
	 * @return bool
	 */
	public function authenticate() {
		if ($this->user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			$this->_id = $this->user->id;
			$this->username = $this->user->username;
			$this->errorCode = self::ERROR_NONE;
		}

		$this->user = User::model()->findByPk($this->user->id);
		return $this->errorCode == self::ERROR_NONE;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->_id;
	}
}
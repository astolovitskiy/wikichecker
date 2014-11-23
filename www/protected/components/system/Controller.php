<?php

class Controller extends CController {

  /**
   * @var string
   */
  public $layout = '//layouts/main';

  /**
   * @var CHttpRequest
   */
  public $request;

  /**
   * @var
   */
  public $config;

  /**
   * @var WebUser
   */
  public $user;

  /**
   * @var string
   */
  protected $_pageTitle;

  /**
   * @var string
   */
  protected $_loggedInRedirectRoute = 'link/index';

  /**
   * @var array
   */
  protected $_jsFiles = array();

  /**
   * @var array
   */
  protected $_cssFiles = array();

  /**
   * void
   */
  public function init() {
    $this->request = Yii::app()->request;
    $this->config = Yii::app()->params;
    $this->user = Yii::app()->user;
  }

  /**
   * @param CAction $action
   * @return bool
   */
  protected function beforeAction($action) {
    return parent::beforeAction($action);
  }

  /**
   * void
   */
  protected function noStoreHeaders() {
    header('Cache-Control: no-store');
    header('Pragma: no-store');
  }

  /**
   * @return string
   */
  public function getPageTitle() {
    if ( ! is_null($this->_pageTitle))
      return $this->_pageTitle;

    return Yii::app()->name;
  }

  /**
   * @param string $value
   */
  public function setPageTitle($value) {
    $this->_pageTitle = $value;
  }

  /**
   * @param $count
   * @param $pageSize
   * @return CPagination
   */
  public function getPages($count, $pageSize) {
    $pages = new CPagination($count);
    $pages->pageSize = $pageSize;
    return $pages;
  }

  /**
   * @param $name
   * @param $value
   * @param $expire
   */
  protected function setCookie($name, $value, $expire = NULL) {
    $cookie = new CHttpCookie($name, $value);
    if( ! is_null($expire))
      $cookie->expire = time() + $expire;
    $cookie->domain = Yii::app()->params['domain'];
    $this->request->cookies[$name] = $cookie;
  }

  /**
   * @param $name
   * @return bool
   */
  public function getCookie($name) {
    if(isset($this->request->cookies[$name]))
      return $this->request->cookies[$name];

    return FALSE;
  }

  /**
   * @param $name
   * @return bool
   */
  protected function deleteCookie($name) {
    if(isset($this->request->cookies[$name])) {
      unset($this->request->cookies[$name]);
      return TRUE;
    }

    return FALSE;
  }

  /**
   * @param array $jsFiles
   */
  public function setJsFiles($jsFiles = array()) {
    $this->_jsFiles = $jsFiles;
  }

  /**
   * @return array
   */
  public function getJsFiles() {
    return $this->_jsFiles;
  }

  /**
   * @param array $cssFiles
   */
  public function setCssFiles($cssFiles = array()) {
    $this->_cssFiles = $cssFiles;
  }

  /**
   * @return array
   */
  public function getCssFiles() {
    return $this->_cssFiles;
  }

  /**
  * @param string $url
  * @param string $flashMessage
  * @param string $flashKey
  */
  public function redirectTo($url, $flashMessage = "", $flashKey = 'alert-success') {
    if ( ! empty($flashMessage))
      $this->user->setFlash($flashKey, $flashMessage);

    if (is_array($url))
      $this->redirect($this->createUrl($url[0], $url[1]));
    else
      $this->redirect($this->createUrl($url));
  }
}

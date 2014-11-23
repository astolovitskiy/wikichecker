<?php

class CrudController extends Controller {

  /**
   * @var int
   */
  const PAGE_LIMIT = 10;

  /**
   * @var string
   */
  const VIEW_PATH = '//crud';

  /**
   * @var array
   */
  protected $_filters = array();

  /**
   * @var null
   */
  protected  $_model = NULL;

  /**
   * @var null
   */
  protected $_form = NULL;

  /**
   * @var null|string
   */
  protected $_filterPath = NULL;

  /**
   * @var array
   */
  protected $_buttons = array(

  );

  /**
   * @var string
   */
  protected $_orderColumn = 'id';

  /**
   * @var string
   */
  protected $_orderDirection = 'ASC';

  /**
   * @return array
   */
  public function getGroupActions() {
    return array(
      'deleteRoutine' => array('oneItem' => FALSE, 'buttonValue' => 'Delete', 'buttonOptions' => array('class' => 'btn btn-danger btn-sm', 'data-original-title' => 'Delete chosen?', 'delete_routine'))
    );
  }

  /**
   * @return ActiveRecord
   * @throws CHttpException
   */
  protected function getItem() {
    $modelName = $this->getModelName();
    $id = $this->request->getParam('id');
    if( ! $id) throw new CHttpException(400, 'Bad request');
    $item = $this->getItemDb($modelName, $id);
    if(! $item) throw new CHttpException(404, 'Page not exist');
    return $item;
  }

  /**
   * @param $modelName string
   * @param $id
   * @return ActiveRecord
   */
  protected function getItemDb($modelName, $id) {
    return $modelName::model()->findByPK($id);
  }

  /**
   * void
   */
  public function actionDelete() {
    $item = $this->getItem();
    if($item->allowDelete()) $item->delete();
    $this->redirectTo($this->getIndexRoute(), FlashMessages::getMessageView(Yii::app()->params['messages']['adminDeleteSuccess'], FlashMessages::TYPE_SUCCESS));
  }

  /**
   * void
   */
  public function actionIndex() {
    $page = $this->request->getParam('page') - 1;
    $limit = $this->request->getParam('limit') ? $this->request->getParam('limit') : self::PAGE_LIMIT;
    $offset = $page * $limit;

    $items = $this->getItems($offset, $limit)->orderBy($this->getOrderColumn(), $this->getOrderDirection());
    $modelName = $this->getModelName();

    $title = $this->getIndexTitle();
    $this->setPageTitle($title);
    $this->render(self::VIEW_PATH.'/index', array('grid' => new Grid(new $modelName, $items, $limit), 'title' => $title));
  }

  /**
   * @return bool
   */
  public function allowCreate() {
    return TRUE;
  }

  /**
   * @var $offset int
   * @var $limit int
   * @return ActiveRecord
   */
  protected function getItems($offset, $limit) {
    $modelName = $this->getModelName();
    $items = $modelName::model()->offset($offset)->limit($limit);

    foreach($this->filters as $attribute => $filterOption)
      $items = $this->getFilter($attribute, $filterOption)->addFilter($items);

    return $items;
  }

  /**
   * @throws CHttpException
   */
  public function actionCreate() {
    if( ! $this->allowCreate()) throw new CHttpException(404, 'Page not found');

    $formName = $this->getFormName();
    $form = new $formName;
    $attributes = $this->request->getParam($formName);
    $form = $this->beforeCreate($form);

    if($attributes) {
      $form = $this->setAttributes($form, $attributes);
      if($this->formSave($form, $attributes))
        $this->redirectTo($this->getIndexRoute(), FlashMessages::getMessageView(Yii::app()->params['messages']['adminCreateSuccess'], FlashMessages::TYPE_SUCCESS));
    }

    $title = $this->_updateTitle;
    $this->setPageTitle($title);
    $this->render(self::VIEW_PATH.'/form', array('model' => $form, 'title' => $title, 'formPath' => $this->_formPath));
  }

  /**
   * @throws CHttpException
   */
  public function actionUpdate() {
    $item = $this->getItem();
    $attributes = $this->request->getParam($this->getFormName());
    if( ! $item->allowUpdate()) throw new CHttpException(404, 'Page not found');

    if($attributes) {
      $item = $this->setAttributes($item, $attributes);
      if($this->formSave($item, $attributes))
        $this->redirectTo($this->getIndexRoute(), FlashMessages::getMessageView(Yii::app()->params['messages']['adminUpdateSuccess'], FlashMessages::TYPE_SUCCESS));
    }

    $title = $this->_updateTitle;
    $this->setPageTitle($title);
    $this->render(self::VIEW_PATH.'/form', array('model' => $item, 'title' => $title, 'formPath' => $this->_formPath));
  }

  /**
   * @throws Exception
   */
  public function actionGroup() {
    $items = $this->getGroupItems();
    $functionName = $this->getGroupAction();
    $groupActions = $this->getGroupActions();

    if(! method_exists($this, $functionName))
      throw new Exception('Callback function '.$functionName.' doesn\'t exists');

    if(Arr::get($groupActions[$functionName], 'oneItem', FALSE))
      foreach($items as $item)
        call_user_func(array($this, $functionName), $item);
    else
      call_user_func(array($this, $functionName), $items);

    $this->redirectTo($this->getIndexRoute());
  }

  /**
   * @return array
   */
  protected function getGroupItems() {
    $criteria = new CDbCriteria();
    $criteria->addInCondition('id', $_POST);
    $model = $this->getModel();

    $models = $model::model()->findAll($criteria);
    return (is_array($models)) ? $models : array();
  }

  /**
   * @return bool|string
   */
  protected function getGroupAction() {

    foreach($this->getGroupActions() as $groupActionName => $groupAction) {
      if(Arr::get($groupAction, 'buttonValue') && $groupAction['buttonValue'] == $this->request->getParam('groupButton'))
        return $groupActionName;
    }

    return FALSE;
  }

  /**
   * @param $items array
   */
  protected function deleteRoutine($items) {
    $success = TRUE;

    foreach($items as $item)
      if($item->allowDelete())
        $item->delete();
      else
        $success = FALSE;

    if($success) $this->user->setFlash('', FlashMessages::getMessageView(Yii::app()->params['messages']['adminGroupDeleteSuccess'], FlashMessages::TYPE_SUCCESS));
    else $this->user->setFlash('', FlashMessages::getMessageView(Yii::app()->params['messages']['adminGroupDeleteError'], FlashMessages::TYPE_ERROR));
  }

  /**
   * @param ActiveRecord $model
   * @return ActiveRecord
   */
  protected function beforeCreate(ActiveRecord $model) {
    return $model;
  }

  /**
   * @param ActiveRecord $model
   * @param $attributes
   * @return ActiveRecord
   */
  protected function setAttributes(ActiveRecord $model, array $attributes) {
    $model->attributes = $attributes;
    return $model;
  }

  /**
   * @param ActiveRecord $model
   * @param array $attributes
   * @return bool
   */
  protected function formSave(ActiveRecord $model, array $attributes) {
    return $model->save();
  }

  /**
   * @return string
   * @throws Exception
   */
  protected function getFormName() {
    if(is_null($this->_form))
      throw new Exception('You need to define form');

    return $this->_form;
  }

  /**
   * @return string
   * @throws Exception
   */
  protected function getModelName() {
    if(is_null($this->_model))
      throw new Exception('You need to define model');

    return $this->_model;
  }

  /**
   * @param $attribute string
   * @param $filterOption array
   * @return Filter
   */
  public function getFilter($attribute, $filterOption) {
    return new $filterOption['type']($attribute, $filterOption, $this->getModel());
  }

  /**
   * @return array
   */
  public function getFilters() {
    return $this->_filters;
  }

  /**
   * @param $limit
   * @param null $route
   * @return string
   */
  public function getLimitUrl($limit, $route = NULL) {
    $get = $_GET;

    if(isset($get['limit'])) unset($get['limit']);

    if(is_null($route))
      $route = $this->getId().'/index';

    $get['limit'] = $limit;
    return $this->createUrl($route, $get);
  }

  /**
   * @return null|string
   */
  public function getModel() {
    return $this->_model;
  }

  /**
   * @return array
   */
  public function getButtons() {
    return $this->_buttons;
  }

  /**
   * @param array $buttons
   */
  public function setButtons(array $buttons) {
    $this->_buttons = $buttons;
  }

  /**
   * @return array
   */
  public function getAdditionalActions() {
    return array();
  }

  /**
   * @param $attributeName string
   */
  public function setOrderColumn($attributeName) {
    $this->_orderColumn = $attributeName;
  }

  /**
   * @param $course string
   */
  public function setOrderDirection($course) {
    $this->_orderDirection = $course;
  }

  /**
   * @return string
   */
  public function getOrderColumn() {
    return $this->_orderColumn;
  }

  /**
   * @return string
   */
  public function getOrderDirection() {
    return $this->_orderDirection;
  }

  /**
   * @return bool
   */
  public function allowCheckboxes() {
    return true;
  }

  /**
   * @return bool
   */
  public function allowActions() {
    return true;
  }

  /**
   * @return string
   */
  protected function getIndexTitle() {
    return $this->_indexTitle;
  }


  /**
   * @return string
   */
  public function getIndexRoute() {
    return $this->getId().'/index';
  }

  /**
   * @return string
   */
  public function getCreateUrl() {
    return $this->createUrl($this->getId().'/create');
  }

  /**
   * @param $id
   * @return string
   */
  public function getUpdateUrl($id) {
    return $this->createUrl($this->getId().'/update', array('id' => $id));
  }

  /**
   * @param $id
   * @return string
   */
  public function getDeleteUrl($id) {
    return $this->createUrl($this->getId().'/delete', array('id' => $id));
  }

  /**
   * @return string
   */
  public function getGroupUrl() {
    return $this->createUrl($this->getId().'/group');
  }
}
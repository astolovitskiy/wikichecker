<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 9/2/14
 * Time: 8:16 PM
 * To change this template use File | Settings | File Templates.
 */

class PageVersionController extends CrudController {

  /**
   * @var null
   */
  protected  $_model = 'PageVersion';

  /**
   * @var null
   */
  protected $_form = 'PageVersion';

  /**
   * @var null
   */
  protected $_formPath = '//page/form';

  /**
   * @var null
   */
  protected $_indexTitle = 'WikiChecker Page Version';

  /**
   * @var string
   */
  protected $_orderDirection = 'DESC';

  /**
   * @return array
   */
  public function getGroupActions() {
    return array();
  }

  /**
   * @return bool
   */
  public function allowCreate() {
    return false;
  }

  /**
   * @return array
   */
  public function getAdditionalActions() {
    return array(
      array(
        'type' => 'btn-success',
        'icon' => 'glyphicon-retweet glyphicon',
        'action' => 'pageVersion/view',
        'title' => 'Difference'
      ),
      array(
        'type' => 'btn-success',
        'icon' => 'glyphicon-search glyphicon',
        'action' => 'pageVersion/fullContent',
        'title' => 'Full content'
      )
    );
  }

  /**
   * void
   */
  public function actionView() {
    $this->setPageTitle('WikiChecker Difference');
    $this->render('//pageVersion/view', array('model' => $this->getItem()));
  }

  /**
   * void
   */
  public function actionFullContent() {
    $this->setPageTitle('WikiChecker Source');
    $this->renderPartial('//pageVersion/fullContent', array('model' => $this->getItem()));
  }

  /**
   * @var $offset int
   * @var $limit int
   * @return PageVersion
   */
  protected function getItems($offset, $limit) {
    $items = parent::getItems($offset, $limit);
    return $items->wherePageId($this->request->getParam('page_id'));
  }
}
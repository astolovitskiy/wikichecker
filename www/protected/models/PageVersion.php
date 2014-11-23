<?php
/**
 * Created by JetBrains PhpStorm.
 * User: astolovitsky
 * Date: 9/2/14
 * Time: 7:58 PM
 * To change this template use File | Settings | File Templates.
 *
 *  @property int $id
 *  @property int $page_id
 *  @property string $created_at
 *  @property Page $page
 */
class PageVersion extends ActiveRecord {

  const VERSIONS_PATH = 'versions';

  /**
   * @return array
   */
  public function attributeLabels() {
    return array(
      'page_id' => 'Page',
      'content' => 'Content',
      'previousLink' => 'Previous version',
      'created_at' => 'Created at'
    );
  }

  /**
   * @return string
   */
  public function tableName() {
    return 'page_version';
  }

  /**
   * @return array
   */
  public function gridColumns() {
    return array(
      'created_at' => 'string',
      'previousLink' => 'string'
    );
  }

  /**
   * @param string $className
   * @return PageVersion
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return array
   */
  public function relations() {
    return array(
      'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
    );
  }

  /**
   * @return bool
   */
  public function allowDelete() {
    return false;
  }

  /**
   * @return bool
   */
  public function allowUpdate() {
    return false;
  }

  /**
   * void
   */
  protected function afterSave() {
    if($this->isNewRecord)
      $this->createPath();

    parent::afterSave();
  }

  /**
   * @return string
   */
  public function getFilePath() {
    return Yii::app()->basePath.'/'.self::VERSIONS_PATH.'/'.$this->page_id.'/'.$this->id.'.html';
  }

  /**
   * @return string
   */
  public function getContent() {
    return file_get_contents($this->getFilePath());
  }

  /**
   * @return PageVersion
   */
  public function getPrevious() {
    $criteria = new CDbCriteria();
    $criteria->addCondition('t.id < :id');
    $criteria->params = array(':id' => $this->id);
    $criteria->order = 'id DESC';
    return PageVersion::model()->wherePageId($this->page_id)->find($criteria);
  }

  /**
   * @return null|string
   */
  public function getPreviousLink() {
    $previous = $this->getPrevious();

    if(! $previous)
      return null;

    return CHtml::link('Previous', Yii::app()->controller->createUrl('pageVersion/view', array('id' => $previous->id)));
  }

  /**
   * @return string|bool
   */
  public function getDiffContent() {
   $previous = $this->getPrevious();

    if($previous) {
      $content = html_entity_decode(strip_tags($this->getContent()));
      $diff = new Diff();
      return $diff->toTable($diff->compare(html_entity_decode(strip_tags($previous->getContent())), $content));
    }

    return false;
  }

  /**
   * @param $pageId
   * @return $this
   */
  public function wherePageId($pageId) {
    $this->getDbCriteria()->mergeWith(array(
      'condition' => 't.`page_id` = :pageId',
      'params' => array(':pageId' => $pageId),
    ));

    return $this;
  }

  /**
   * void
   */
  public function sendNotification() {
    if($content = $this->getDiffContent()) {
      $subject = 'Wikichecker: Wikipedia page "'.$this->page->name.'" update';
      Email::send($this->page->email, $subject, $content);
    }
  }

  /**
   * void
   */
  private function createPath() {
    $pathInfo = pathinfo($this->getFilePath());
    $folder = $pathInfo['dirname'];

    if(! file_exists($folder))
      mkdir($folder, 0777, true);
  }
}
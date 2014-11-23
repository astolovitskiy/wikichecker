<?php

/**
 *  @property int $id
 *  @property string $url
 *  @property string $name
 *  @property string $description
 *  @property int $versionsCount
 *  @property string $email
 *  @property PageVersion[] $versions
 *  @property PageVersion $lastVersion
 */
class Page extends ActiveRecord {

  /**
   * @return array
   */
  public function rules() {
    return array(
      array('url, name, email', 'required'),
      array('url, name, description, email', 'safe'),
      array('url', 'unique'),
    );
  }

  /**
   * @return array
   */
  public function attributeLabels() {
    return array(
      'name' => 'Name',
      'url' => 'Url',
      'link' => 'Url',
      'description' => 'Description',
      'versions' => 'Versions',
    );
  }

  /**
   * @return string
   */
  public function tableName() {
    return 'page';
  }

  /**
   * @return array
   */
  public function gridColumns() {
    return array(
      'name' => 'string',
      'link' => 'string',
      'versions' => array('type' => 'template', 'template' => '${versionsLink}'),
    );
  }

  /**
   * @param string $className
   * @return Page
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return array
   */
  public function relations() {
    return array(
      'versions' => array(self::HAS_MANY, 'PageVersion', 'page_id'),
      'versionsCount' => array(self::STAT, 'PageVersion', 'page_id'),
      'lastVersion' => array(self::HAS_ONE, 'PageVersion', 'page_id', 'order' => 'id DESC'),
    );
  }

  /**
   * @return string
   */
  public function getVersionsLink() {
    return CHtml::link('('.$this->versionsCount.')', Yii::app()->controller->createUrl('pageVersion/index', array('page_id' => $this->id)));
  }

  /**
   * @return string
   */
  public function getLink() {
    return CHtml::link($this->url, $this->url);
  }
}


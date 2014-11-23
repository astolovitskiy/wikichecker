<?php

class m140902_144033_create_table_link extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up() {
    $this->createTable('link', array(
        'id' => 'pk',
        'name' => 'VARCHAR(255) NOT NULL',
        'url' => 'VARCHAR(255) NOT NULL',
        'description' => 'VARCHAR(255) DEFAULT NULL',
      ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8'
    );
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_144033_create_table_link does not support migration down.\n";
    return false;
  }
}
<?php

class m140902_165029_create_table_page_version extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up() {
    $this->createTable('page_version', array(
        'id' => 'pk',
        'page_id' => 'INT(11) NOT NULL',
        'previous_version_id' => 'INT(11) DEFAULT NULL',
        'content' => 'TEXT',
        'created_at' => 'datetime',
      ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8'
    );

    $this->addForeignKey('FK_page_page_version', 'page_version', 'page_id', 'page', 'id', 'CASCADE', 'CASCADE');
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_144033_create_table_link does not support migration down.\n";
    return false;
  }
}
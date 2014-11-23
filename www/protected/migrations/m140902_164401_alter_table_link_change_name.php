<?php

class m140902_164401_alter_table_link_change_name extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up() {
    $this->renameTable('link', 'page');
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_164401_alter_table_link_change_name does not support migration down.\n";
    return false;
  }
}
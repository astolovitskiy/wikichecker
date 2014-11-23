<?php

class m140902_222147_alter_table_page_version_remove_column extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up()  {
    $this->dropColumn('page_version', 'previous_version_id');
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_144033_create_table_link does not support migration down.\n";
    return false;
  }

}
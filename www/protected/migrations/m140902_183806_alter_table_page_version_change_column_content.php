<?php

class m140902_183806_alter_table_page_version_change_column_content extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up()  {
    $this->alterColumn('page_version', 'content', 'BLOB');
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_144033_create_table_link does not support migration down.\n";
    return false;
  }
}
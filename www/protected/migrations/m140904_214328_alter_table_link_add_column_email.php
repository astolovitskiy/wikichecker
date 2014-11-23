<?php

class m140904_214328_alter_table_link_add_column_email extends CDbMigration {

  /**
   * @return bool|void
   */
  public function up()  {
    $this->addColumn('page', 'email', 'VARCHAR(255)');
  }

  /**
   * @return bool
   */
  public function down() {
    echo "m140902_144033_create_table_link does not support migration down.\n";
    return false;
  }

}
<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Create_table extends CI_Migration {
    public function up() {
        $this-> _drop_column_description();
    }

    private function _drop_column_description() {
        $this->dbforge->drop_column('risk_types','project_id');
    }
    public function down() {

    }
}
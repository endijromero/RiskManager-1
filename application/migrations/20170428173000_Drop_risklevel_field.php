<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Drop_risklevel_field extends CI_Migration {
    public function up() {
        $this-> _drop_column_description();
    }

    private function _drop_column_description() {
        $this->dbforge->drop_column('fitness','risk_level');
    }
    public function down() {

    }
}
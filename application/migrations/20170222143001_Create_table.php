<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Create_table extends CI_Migration {
    public function up() {
        $this-> _add_column_description();
    }

    private function _add_column_description() {
        $fields = array(
                'project_id' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'after'      => 'id',
            ),
        );
        $this->dbforge->add_column('risk_types', $fields);
    }
    public function down() {

    }
}
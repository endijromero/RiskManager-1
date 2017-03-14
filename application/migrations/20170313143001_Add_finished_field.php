<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Add_finished_field extends CI_Migration {
    public function up() {
        $this-> _add_column_description();
    }

    private function _add_column_description() {
        $fields = array(
                'finished' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
                'after'      => 'createdAt',
            ),
        );
        $this->dbforge->add_column('projects', $fields);
    }
    public function down() {

    }
}
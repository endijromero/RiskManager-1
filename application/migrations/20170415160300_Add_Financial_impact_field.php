<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Add_Financial_impact_field extends CI_Migration {
    public function up() {
        $this-> _add_column_description();
    }

    private function _add_column_description() {
        $fields = array(
                'financial_impact' => array(
                'type'       => 'INT',
                'constraint' => 11,
                'after'      => 'description',
            ),
        );
        $this->dbforge->add_column('risks', $fields);
    }
    public function down() {

    }
}
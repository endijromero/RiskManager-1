<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Add_Fitness_function_weights_risklevel_field extends CI_Migration {
    public function up() {
        $this-> _add_column_description();
    }

    private function _add_column_description() {
        $fields = array(
                'risk_level' => array(
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'after'      => 'financial_impact',
            ),
        );
        $this->dbforge->add_column('fitness', $fields);
    }
    public function down() {

    }
}
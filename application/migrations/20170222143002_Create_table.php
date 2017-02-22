<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Create_table extends CI_Migration {
    public function up() {
        $this-> change_typeof_description();
    }

    private function change_typeof_description() {
        $sql = "ALTER TABLE `conflicts` CHANGE COLUMN `method_1_id`  `method_1_code` varchar(20)  DEFAULT NULL;";
        $this->db->query($sql);
        $sql = "ALTER TABLE `conflicts` CHANGE COLUMN `method_2_id`  `method_2_code`  varchar(20) DEFAULT NULL;";
        $this->db->query($sql);
    }
    public function down() {

    }
}
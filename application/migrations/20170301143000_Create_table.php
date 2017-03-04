<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Create_table extends CI_Migration {
    public function up() {
        $this->_create_fitness_table();
    }
    private function _create_fitness_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `fitness` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`project_id` int(11) NOT NULL,
`cost` int(11) NOT NULL,
`diff` int(11) NOT NULL,
`priority` int(11) NOT NULL,
`time` int(11) NOT NULL,
`createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
`deleted` int(11) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }
    public function down() {
        $this->dbforge->drop_table('fitness', FALSE);
    }
}
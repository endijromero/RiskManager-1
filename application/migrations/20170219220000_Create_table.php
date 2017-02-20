<?php

/**
 * Created by PhpStorm.
 * User: Hp
 * Date: 2/19/2017
 * Time: 10:29 PM
 */
class Migration_Create_table extends CI_Migration {
    public function up() {
        $this->_create_methods_table();
        $this->_create_conflicts_table();
        $this->_create_projects_table();
        $this->_create_risk_types_table();
        $this->_create_risks_table();
    }

    private function _create_methods_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `methods` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `risk_id` int(11) NOT NULL,
                  `code` varchar(20) DEFAULT NULL,
                  `name` varchar(50) DEFAULT NULL,
                  `cost` int(11) NOT NULL DEFAULT '0',
                  `diff` int(5) NOT NULL DEFAULT '0',
                  `priority` int(5) NOT NULL DEFAULT '0',
                  `time` int(11) NOT NULL DEFAULT '0',
                  `description` text,
                  `createdAt`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                  `deleted` int(11) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    private function _create_projects_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `projects` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `code` varchar(20) DEFAULT NULL,
                  `name` varchar(50) DEFAULT NULL,
                  `risk_quantity` int(11) DEFAULT NULL,
                  `description` text,
                  `createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                  `deleted` int(11) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    private function _create_conflicts_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `conflicts` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `project_id` int(11) NOT NULL,
              `method_1_id` int(11) NOT NULL,
              `method_2_id` int(11) NOT NULL,
              `code` varchar(20)  DEFAULT NULL,
              `name` varchar(50)  DEFAULT NULL,
              `description` text,
              `createdAt`  TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted` int(11) NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    private function _create_risks_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `risks` (
              `id` int(11) NOT NULL,
              `project_id` int(11) NOT NULL,
              `risk_type_id` int(11) NOT NULL,
              `code` varchar(20) DEFAULT NULL,
              `name` varchar(50) DEFAULT NULL,
              `method_quantity` int(11) DEFAULT NULL,
              `description` text,
              `createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              `deleted` int(11) NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    private function _create_risk_types_table() {
        $sql = "CREATE TABLE IF NOT EXISTS `risk_types` (
                  `id` int(11) NOT NULL,
                  `code` varchar(20) DEFAULT NULL,
                  `name` varchar(50) DEFAULT NULL,
                  `description` text,
                  `createdAt` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                  `deleted` int(11) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    public function down() {
        $this->dbforge->drop_table('risk_types', FALSE);
        $this->dbforge->drop_table('risks', FALSE);
        $this->dbforge->drop_table('conflicts', FALSE);
        $this->dbforge->drop_table('projects', FALSE);
        $this->dbforge->drop_table('methods', FALSE);
    }
}
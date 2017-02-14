<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong204
 * Date: 01/04/2016
 * Time: 11:37 AM
 */

/**
 * Class Migration_Init
 *
 * @property CI_DB_query_builder $db
 * @property CI_DB_forge         $dbforge
 */
class Migration_Add_demo_user extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE `users` ADD COLUMN `avatar` varchar(255) AFTER `email`;");
    }

    public function down() {
        $this->dbforge->drop_table('users_demo');
    }
}
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
class Migration_Init_ionauth extends CI_Migration {

    public function up() {
        $this->_clear_database(TRUE);
        //ion-auth table
        $this->_create_table_user();
        $this->_create_table_group();
        $this->_create_table_user_group();
        $this->_create_table_login_attempt();
    }

    public function down() {
        $this->_clear_database(FALSE);
    }

    private function _create_table_user() {
        $this->dbforge->add_field(array(
            'id'                      => array(
                'type'           => 'MEDIUMINT',
                'constraint'     => '8',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE,
            ),
            'ip_address'              => array(
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ),
            'username'                => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'name'                    => array(
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => TRUE,
            ),
            'password'                => array(
                'type'       => 'VARCHAR',
                'constraint' => '80',
            ),
            'salt'                    => array(
                'type'       => 'VARCHAR',
                'constraint' => '40',
            ),
            'email'                   => array(
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ),
            'activation_code'         => array(
                'type'       => 'VARCHAR',
                'constraint' => '40',
                'null'       => TRUE,
            ),
            'forgotten_password_code' => array(
                'type'       => 'VARCHAR',
                'constraint' => '40',
                'null'       => TRUE,
            ),
            'forgotten_password_time' => array(
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => TRUE,
                'null'       => TRUE,
            ),
            'remember_code'           => array(
                'type'       => 'VARCHAR',
                'constraint' => '40',
                'null'       => TRUE,
            ),
            'created_on'              => array(
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => TRUE,
            ),
            'last_login'              => array(
                'type'       => 'INT',
                'constraint' => '11',
                'unsigned'   => TRUE,
                'null'       => TRUE,
            ),
            'active'                  => array(
                'type'       => 'TINYINT',
                'constraint' => '1',
                'unsigned'   => TRUE,
                'null'       => TRUE,
            ),
            'deleted'                 => array(
                'type'       => 'INT',
                'constraint' => '11',
                'default'    => 0,
            ),

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');

        // Dumping data for table 'users'
        $data = array(
            'id'                      => '1',
            'ip_address'              => '127.0.0.1',
            'username'                => 'administrator',
            'name'                    => 'Administrator',
            'password'                => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
            'salt'                    => '',
            'email'                   => 'admin@admin.com',
            'activation_code'         => '',
            'forgotten_password_code' => NULL,
            'created_on'              => '1268889823',
            'last_login'              => '1268889823',
            'active'                  => '1',
        );
        $this->db->insert('users', $data);
    }

    private function _create_table_group() {
        $table_name = "ion_groups";
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
            `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(20) NOT NULL,
            `description` varchar(100) NOT NULL,
            `deleted` int(11) DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);

        //Create default group
        $this->db->insert_batch($table_name, Array(
            Array(
                'id'          => 1,
                'name'        => 'admin',
                'description' => 'Administrator',
            ),
            Array(
                'id'          => 2,
                'name'        => 'develop',
                'description' => 'Develop',
            ),
        ));

    }

    private function _create_table_user_group() {
        $table_name = "ion_users_groups";
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `user_id` int(11) unsigned NOT NULL,
                  `group_id` mediumint(8) unsigned NOT NULL,
                  `deleted` int(11) DEFAULT '0',
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
                  KEY `fk_users_groups_users1_idx` (`user_id`),
                  KEY `fk_users_groups_groups1_idx` (`group_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);

        //Insert group for admin
        $this->db->insert_batch($table_name, Array(
            Array(
                'user_id'  => '1',
                'group_id' => '1',
            ),
        ));
    }

    private function _create_table_login_attempt() {
        $sql = "CREATE TABLE IF NOT EXISTS `ion_login_attempts` (
                  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                  `ip_address` varchar(15) NOT NULL,
                  `login` varchar(100) NOT NULL,
                  `time` int(11) unsigned DEFAULT NULL,
                  `deleted` int(11) DEFAULT '0',
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $this->db->query($sql);
    }

    private function _clear_database($if_exitst = FALSE) {
        $this->dbforge->drop_table('users', $if_exitst);
        $this->dbforge->drop_table('ion_groups', $if_exitst);
        $this->dbforge->drop_table('ion_users_groups', $if_exitst);
        $this->dbforge->drop_table('ion_login_attempts', $if_exitst);
    }
}
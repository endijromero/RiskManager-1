QQV<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Project
 */
class Projects extends Manager_base {
    public function __construct() {
        parent::__construct();
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "projects",
            "view"   => "projects",
            "model"  => "m_projects",
            "object" => "Dự Ánnn",
        );
    }
//    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
//        return "<a href='project'>$origin_column_value</a>";
//    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 */
class Home extends Manager_base {
    public function __construct() {
        parent::__construct();
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "home",
            "view"   => "home",
            "model"  => "m_project",
            "object" => "Dự Án",
        );
    }
    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="projects/detail/'.$record->id.'">'.$origin_column_value.'</a>';
    }
}
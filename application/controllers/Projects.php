<?php
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
        $this->load->model('m_project');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "project",
            "view"   => "project",
            "model"  => "m_project",
            "object" => "Dự Án",
        );
    }
//    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
//        return "<a href='project'>$origin_column_value</a>";
//    }
    function detail($id) {
        $data['detail_project'] = $this->model->get($id);
        $content = $this->load->view("admin/font/project_detail", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }
}
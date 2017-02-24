<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Hint
 */
class Hint extends Manager_base {
    public function __construct() {
        parent::__construct();

    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "hint",
            "view"   => "hint",
            "model"  => "m_project",
            "object" => "Gợi ý",
        );
    }

    function manage($id) {
        $data['detail_project'] = $this->model->get($id);
        $content = $this->load->view("admin/font/hint", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }
}
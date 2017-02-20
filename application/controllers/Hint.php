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
            "model"  => "",
            "object" => "Dự Án",
        );
    }

    public function project($id) {
        $data=NULL;
        $content = $this->load->view("admin/font/hint", $data, TRUE);
        $this->show_page($content);
    }
}
<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 3/17/16
 * Time: 13:01
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 */
class Errors extends Admin_layout {

    function __construct() {
        parent::__construct();
    }

    /**
     * check user are logged in before jump into Master admin
     */
    public function page_missing() {
        $data = Array();
        http_response_code(404);
        $content = $this->load->view("admin/base_layout/error_404", $data, TRUE);
        $this->show_page($content);
    }


}
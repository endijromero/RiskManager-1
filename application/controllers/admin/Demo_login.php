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
class Demo_login extends Admin_login_layout {

    function __construct() {
        parent::__construct();
    }

    /**
     * check user are logged in before jump into Master admin
     */
    public function index() {
        $this->load_more_js("assets/js/page/login.js", TRUE);
        $data = Array();
        $data["login_url"] = site_url("admin/demo_login/check");
        $data["recover_url"] = site_url("admin/demo_login/reset_password");
        $content = $this->load->view("admin/demo_login/content", $data, TRUE);
        $this->show_page($content);
    }

    public function check() {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $dataReturn = Array();
            $dataReturn["callback"] = "login_response";
            $email = $this->input->post("username");
            $pass = $this->input->post("password");
            $login = $this->ion_auth->login($email, $pass);
            if ($login) {
                $dataReturn["state"] = 1;
                $dataReturn["msg"] = "Đăng nhập thành công";
                $dataReturn["redirect"] = site_url("admin/demo_user");
            } else {
                $dataReturn["state"] = 0;
                $dataReturn["msg"] = "Tên đăng nhập hoặc mật khẩu không chính xác";
            }
            echo json_encode($dataReturn);
        } else {
            redirect();
        }
    }

}
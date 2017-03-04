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
 * @property M_user $m_user
 */
class Login extends Admin_login_layout {

    function __construct() {
        parent::__construct();
        $this->load->model("m_user");
    }

    /**
     * check user are logged in before jump into Master admin
     */
    public function index() {
        if ($this->ion_auth->logged_in()) {
            $url = $this->session->userdata('redirect_login');
            $url = $url ? $url : site_url();
            $this->session->unset_userdata('redirect_login');
            redirect($url);
        }
        $this->load_more_js("assets/js/page/login.js", TRUE);
        $data = Array();
        $data["login_url"] = site_url("login/check");
        $data["recover_url"] = site_url("login/reset");
        $data["register_url"] = site_url("login/register");
        $content = $this->load->view("admin/login/content", $data, TRUE);
        $this->show_page($content);
    }

    public function check() {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $dataReturn = Array();
            $dataReturn["callback"] = "login_response";
            $email = $this->input->post("username");
            $pass = $this->input->post("password");
            $user = $this->ion_auth->get_user($email);
            $login = $this->ion_auth->login($email, $pass);
            if ($login) {
                $this->set_more_session();
                $dataReturn["state"] = 1;
                $dataReturn["msg"] = "Đăng nhập thành công";
                $url = $this->session->userdata('redirect_login');
                $id = $this->session->userdata('user_id');
                $url = $url ? $url : site_url( );
                $this->session->unset_userdata('redirect_login');
                $dataReturn["redirect"] = $url;
            } else {
                $dataReturn["state"] = 0;
                $dataReturn["msg"] = "Tên đăng nhập hoặc mật khẩu không chính xác";
            }
            echo json_encode($dataReturn);
        } else {
            redirect();
        }
    }

    private function set_more_session() {
        $group_db = $this->ion_auth->get_users_groups();
        $group = [];
        foreach ($group_db->result() as $item) {
            $group[$item->name] = $item;
        }
        $this->session->set_userdata("user_groups", $group);

        $user = $this->ion_auth->user()->row();
        $this->session->set_userdata("user_name", $user->name);

    }
    public function register() {
        if ($this->input->is_ajax_request() && $this->input->post()) {
            $dataReturn = Array();
            $dataReturn["callback"] = "register_response";
            $email = $this->input->post("email");
            $username = $this->input->post("username");
            $password = $this->input->post("password");
            $additional_data = array(
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'password_confirm' => $this->input->post('password_confirm')
            );
            var_dump($additional_data);
            $groups = array();
            if ($this->ion_auth->is_admin())
            {
                $this->data['groups'] = $this->ion_auth->groups()->result_array(); // выбираем все группы
                $groups=$this->data['groups'];
            }
             $this->ion_auth->register($email, $password, $additional_data, $groups);


        } else {
            redirect();
        }

    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url("login"));
    }

}
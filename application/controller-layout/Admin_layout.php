<?php
/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 3/17/16
 * Time: 11:16
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Admin_layout extends Base_layout {

    protected $role_allow = 'admin';

    function __construct() {
        parent::__construct();
        $this->_set_side_bar_left();
        $this->_set_top_bar();
        $this->check_role();
    }

    private function _set_side_bar_left() {
        $menu[] = Array(
            "text" => "Trang chủ",
            "icon" => "fa-dashboard",
            "url"  => site_url('home'),
        );

        $project_id = $this->session->userdata('project_id');
        if ($project_id) {
            $project_menu[] = Array(
                "text" => "Quản lí loại rủi ro",
                "icon" => "fa-dashboard",
                "url"  => site_url('risk_type/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Quản lí rủi ro",
                "icon" => "fa-dashboard",
                "url"  => site_url('risk/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Quản lí xung đột",
                "icon" => "fa-dashboard",
                "url"  => site_url('conflict/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Quản lí trọng số hàm thích nghi",
                "icon" => "fa-dashboard",
                "url"  => site_url('fitness/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Yêu cầu trợ giúp ra quyết định",
                "icon" => "fa-dashboard",
                "url"  => site_url('hint/manage/' . $project_id),
            );
            $menu[] = Array(
                "text"  => "Quản lí dự án",
                "icon"  => "fa-table",
                "url"   => site_url('hint/manage/' . $project_id),
                "child" => $project_menu,
            );
        }

        $menu[] = Array(
            "text" => "Người dùng",
            "icon" => "fa-users",
            "url"  => site_url('user'),
        );

        $data = Array(
            'view_file' => "admin/base_layout/side_bar_left",
            'menu_data' => $menu,
        );
        $this->set_data_part('side_bar_left', $data, TRUE);
    }

    private function _set_top_bar() {
        $data = Array(
            'view_file' => "admin/base_layout/top_bar",
        );
        $this->set_data_part('top_bar', $data, TRUE);
    }

    protected function check_role() {
        return TRUE;
        if (!$this->ion_auth->logged_in()) {
            $this->redirect_to_login();
        }
        if (!$this->ion_auth->in_group($this->role_allow)) {
            $this->ion_auth->logout();
            $this->redirect_to_login();
        }
    }

    protected function redirect_to_login() {
        $login_link = site_url("admin/login");
        $this->session->set_userdata('redirect_login', current_url());
        $this->session->set_flashdata("msg", "<div class='alert alert-warning'>Required login!</div>");
        redirect($login_link);
    }
}

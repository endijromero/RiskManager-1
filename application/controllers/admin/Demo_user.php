<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 14/06/16
 * Time: 16:56
 */
class Demo_user extends Manager_base {

    function __construct() {
        parent::__construct();
    }

    //Using on demo only
    protected function redirect_to_login() {
        $login_link = site_url("admin/demo_login");
        $this->session->set_userdata('redirect_login', current_url());
        $this->session->set_flashdata("msg", "<div class='alert alert-warning'>Required login!</div>");
        redirect($login_link);
    }

    /**
     * Hàm cài đặt biến $name cho controller (xem trong 1 controller bất kỳ để biết chi tiết)
     */
    function setting_class() {
        $this->name = Array(
            "class"  => "admin/demo_user",
            "view"   => "admin/demo_user",
            "model"  => "m_demo_user",
            "object" => "tài khoản",
        );
    }

    protected function custom_render_password($form_item, $form_id, $value) {
        $data = [
            'form_item' => $form_item,
            'form_id'   => $form_id,
        ];
        return $this->load->view($this->path_theme_view . "demo_user/password", $data, TRUE);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return "<a href='#'>$origin_column_value</a>";
    }
}
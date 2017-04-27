<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 14/06/16
 * Time: 16:56
 *
 * @property M_user model
 */
class User extends Manager_base {
    protected $role_allow = 'admin';

    function setting_class() {
        $this->name = Array(
            "class"  => "user",
            "view"   => "admin/user",
            "model"  => 'm_user',
            "object" => "User",
        );
    }

    public function add_action_button($origin_column_value, $column_name, &$record, $column_data, $caller) {
        if ($this->is_in_group(['admin'])) {
            $primary_key = $this->model->get_primary_key();
            $custom_action = "<div class='action-buttons'>";
            if ((!isset($record->disable_edit) || !$record->disable_edit)) {
                $custom_action .= "<a class='green' href='" . site_url('user/edit_company/' . $record->$primary_key) . "'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $custom_action .= "<a class='e_ajax_link e_ajax_confirm red' href='" . site_url($this->url["delete"] . $record->$primary_key) . "'><i class='ace-icon fa fa-trash-o  bigger-130'></i></a>";
            }
            $custom_action .= "</div>";
            return $custom_action;
        } else {
            $primary_key = $this->model->get_primary_key();
            $custom_action = "<div class='action-buttons'>";
            if ((!isset($record->disable_edit) || !$record->disable_edit)) {
                $custom_action .= "<a class='e_ajax_link green' href='" . site_url($this->url["edit"] . $record->$primary_key) . "'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
                $custom_action .= "<a class='e_ajax_link e_ajax_confirm red' href='" . site_url($this->url["delete"] . $record->$primary_key) . "'><i class='ace-icon fa fa-trash-o  bigger-130'></i></a>";
            }
            $custom_action .= "</div>";
            return $custom_action;
        }
    }

    protected function custom_render_password($form_item, $form_id) {
        $data = [
            'form_item' => $form_item,
            'form_id'   => $form_id,
        ];
        return $this->load->view($this->path_theme_view . "user/password", $data, TRUE);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return "<a href='#'>$origin_column_value</a>";
    }

    public function profile() {
        $id = $this->session->userdata("user_id");
        $data = [
            "save_link"  => site_url($this->name["class"] . "/profile_save"),
            'form_title' => 'Profile',
        ];
        unset($this->model->schema['role_id']);
        unset($this->model->schema['active']);
        $this->model->include_my_profile();
        $this->edit($id, $data);
    }

    public function profile_save() {
        $id = $this->session->userdata("user_id");
        unset($this->model->schema['role_id']);
        unset($this->model->schema['active']);
        $this->model->include_my_profile();
        $this->edit_save($id);
    }

    public function is_in_group($group) {
        return $this->ion_auth->in_group($group);
    }
}
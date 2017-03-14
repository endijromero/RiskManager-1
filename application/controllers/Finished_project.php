<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 3/13/2017
 * Time: 7:42 PM
 */

/**
 * Class Finished_project
 *
 * @property M_project model
 */
class Finished_project extends Manager_base {

    public function setting_class() {
        $this->name = Array(
            "class"  => "finished_project",
            "view"   => "finished_project",
            "model"  => "m_project",
            "object" => "dự án kết thúc",
        );
    }

    public function manager($data = Array()) {
        if (!isset($data["view_file"])) {
            $data["view_file"] = $this->name['view'] . '/manager_container';
        }
        parent::manager($data);
    }

    public function ajax_list_data($data = Array()) {
        $this->model->set_allowed_status('finished');
        return parent::ajax_list_data($data);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
//        return '<a href="' . site_url($this->name['class'] . '/manage_project/' . $record->id) . '">' .
//        $origin_column_value . '</a>';
        return $origin_column_value;
    }

    public function add_action_button($origin_column_value, $column_name, &$record, $column_data, $caller) {
        $primary_key = $this->model->get_primary_key();
        $custom_action = "<div class='action-buttons'>";
//        $custom_action .= "<a class='e_ajax_link blue' href='" . site_url($this->url["view"] . $record->$primary_key) . "'><i class='ace-icon fa fa-search-plus bigger-130'></i></a>";
        if ((!isset($record->disable_edit) || !$record->disable_edit)) {
//            $custom_action .= "<a class='e_ajax_link green' title=\"Sửa\"href='" . site_url($this->url["edit"] . $record->$primary_key) . "'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
            $custom_action .= "<a class='e_ajax_link e_ajax_confirm red'title=\"Xóa\" href='" . site_url($this->url["delete"] . $record->$primary_key) . "'><i class='ace-icon fa fa-trash-o  bigger-130'></i></a>";
        }
        $custom_action .= "</div>";
        return $custom_action;
    }
}
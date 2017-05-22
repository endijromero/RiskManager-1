<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 *
 * @property M_project model
 */
class Home extends Manager_base {
    public function __construct() {
        parent::__construct();
        $this->load->model('m_risk');
        $this->url["add"] = site_url($this->name["class"] . "/create");
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "home",
            "view"   => "home",
            "model"  => "m_project",
            "object" => "Project list",
        );
    }

    public function ajax_list_data($data = Array()) {
        $this->model->set_allowed_status('in_progress');
        return parent::ajax_list_data($data);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="' . site_url('home/manage_project/' . $record->id) . '">' . $origin_column_value . '</a>';
    }

    public function manage_project($project_id) {
        $this->session->set_userdata('project_id', $project_id);
        redirect(site_url('home/detail/' . $project_id));
    }

    function detail($id) {
        $data['detail_project'] = $this->model->get($id);
        $content = $this->load->view("admin/font/project_detail", $data, TRUE);
        $this->load_more_js("assets/js/front/front_util.js", TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }

    public function create($data = Array(), $data_return = Array()) {
        if (!isset($data["save_link"])) {
            $data["save_link"] = site_url($this->name["class"] . "/create_save/");
        }
        return $this->add($data, $data_return);
    }

    public function create_save($data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
        }
        if ($data['code'] == NULL || $data['name'] == NULL || $data['description'] == NULL) {
            echo json_encode([
                'state' => 0,
                'msg'   => 'Invalid data!
                Don\'t leave the inputs empty.',
            ]);;
            return 0;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

    protected function add_action_button($origin_column_value, $column_name, &$record, $column_data, $caller) {
        $primary_key = $this->model->get_primary_key();
        $custom_action = "<div class='action-buttons'>";
//        $custom_action .= "<a class='e_ajax_link blue' href='" . site_url($this->url["view"] . $record->$primary_key) . "'><i class='ace-icon fa fa-search-plus bigger-130'></i></a>";
        if ((!isset($record->disable_edit) || !$record->disable_edit)) {
            $custom_action .= "<a class='e_ajax_link green' title=\"Edit\"href='" .
                site_url($this->url["edit"] . $record->$primary_key) .
                "'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
            $custom_action .= "<a class='e_ajax_link e_ajax_confirm blue' data-label-cancel='Hủy' 
                data-label-submit='Kết thúc' title=\"Finish project\"href='" .
                site_url($this->name["class"] . '/finish/' . $record->$primary_key) .
                "'><i class='fa fa-check-square-o bigger-130'></i></a>";
            $custom_action .= "<a class='e_ajax_link e_ajax_confirm red'title=\"Delete\" href='" .
                site_url($this->url["delete"] . $record->$primary_key) .
                "'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
        }
        $custom_action .= "</div>";
        return $custom_action;
    }

    public function finish($id = 0, $data = Array(), $data_return = Array()) {
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "delete_respone";
        }
        $id = intval($id);
        if (!$id) {
            $data_return["state"] = 0; /* state = 0 : invalid id */
            $data_return["msg"] = "Project does not exist";
            echo json_encode($data_return);
            return FALSE;
        }
        if ($this->input->post() || $id > 0) {
            if (isset($data["list_id"]) && sizeof($data["list_id"])) {
                $list_id = $data["list_id"];
            } else {
                if ($this->input->post() && $id == "0") {
                    $list_id = $this->input->post("list_id");
                } elseif ($id > 0) {
                    $list_id = Array($id);
                }
            }
            $data['finished'] = '1';
            $update = $this->model->update_many($list_id, $data, TRUE);
            $data_return["list_id"] = [$id];
            if ($update) {
                $data_return["key_name"] = $this->model->get_primary_key();
                $data_return["record"] = $this->standard_record_data($this->model->get($id));
                $data_return["state"] = 1; /* state = 1 : insert success */
                $data_return["msg"] = "Mark as finished.";
                echo json_encode($data_return);
                return TRUE;
            } else {
                $data_return["data"] = $data;
                $data_return["state"] = 0; /* state = 0 : invalid data */
                $data_return["msg"] = "This project is already finished of have not enough conditions.";
                echo json_encode($data_return);
                return FALSE;
            }
        } else {
            $data_return["state"] = 0;
            $data_return["msg"] = "Project does not exist";
            echo json_encode($data_return);
            return FALSE;
        }
    }
}
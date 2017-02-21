<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/21/2017
 * Time: 8:38 PM
 */

/**
 * Class Abs_child_manager
 *
 * @property Abs_child_model model
 * @property M_project       project
 */
abstract class Abs_child_manager extends Manager_base {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_project', "project");
        $this->url["add"] = site_url($this->name["class"] . "/create");
    }

    public function create($project_id, $data = Array(), $data_return = Array()) {
        if (!isset($data["save_link"])) {
            $data["save_link"] = site_url($this->name["class"] . "/create_save/" . $project_id);
        }
        return $this->add($data, $data_return);
    }

    public function create_save($project_id, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data['project_id'] = $project_id;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

    public function manage($project_id, $data = Array()) {
        $data["add_link"] = $this->url["add"] . '/' . $project_id;
        $data["view_file"] = "child/manager_container";
        $data["ajax_data_link"] = site_url($this->name["class"] . "/ajax_list_data_by_project_id/" . $project_id);
        $data['project_id'] = $project_id;
        $this->manager($data);
    }

    public function ajax_list_data_by_project_id($project_id, $data = Array()) {
        $this->model->set_project_id($project_id);
        $result = $this->ajax_list_data($data);
        $this->model->set_project_id(0);
        return $result;
    }
}
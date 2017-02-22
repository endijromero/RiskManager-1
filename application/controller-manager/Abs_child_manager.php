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
 */
abstract class Abs_child_manager extends Manager_base {
    protected $_parent_field = 'project_id';
    public function __construct() {
        parent::__construct();
        $this->url["add"] = site_url($this->name["class"] . "/create");
    }

    public function create($parent_value, $data = Array(), $data_return = Array()) {
        if (!isset($data["save_link"])) {
            $data["save_link"] = site_url($this->name["class"] . "/create_save/" . $parent_value);
        }
        return $this->add($data, $data_return);
    }

    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

    public function manage($parent_value, $data = Array()) {
        $data["add_link"] = $this->url["add"] . '/' . $parent_value;
        $data["view_file"] = "child/manager_container";
        $data["ajax_data_link"] = site_url($this->name["class"] . "/ajax_list_data_by_project_id/" . $parent_value);
        $data['project_id'] = $parent_value;
        $this->manager($data);
    }

    public function ajax_list_data_by_project_id($parent_value, $data = Array()) {
        $this->model-> set_parent($parent_value);
        $result = $this->ajax_list_data($data);
        $this->model->set_parent(0);
        return $result;
    }
}
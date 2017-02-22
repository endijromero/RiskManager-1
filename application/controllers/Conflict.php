<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Conflict
 *
 * @property M_conflict model
 * @property M_risk     m_risk
 * @property M_method   m_method
 */
class Conflict extends Abs_child_manager {
    public $_parent_field = 'project_id';

    public function __construct() {
        parent::__construct();
        $this->load_more_css("assets/css/font/detail.css");
        $this->load_more_js("assets/js/front/conflict.js");
        $this->load->model('m_risk');
        $this->load->model('m_method');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "conflict",
            "view"   => "conflict",
            "model"  => "m_conflict",
            "object" => "Xung Đột",
        );
    }

    public function create($parent_value, $data = Array(), $data_return = Array()) {
        $id = $parent_value;
        $data['list_risk'] = $this->m_risk->get_many_by(['project_id' => $id]);
        $data["view_file"] = $this->name['view'] . '/conflict_add_form';
        return parent::create($parent_value, $data, $data_return);
    }

    public function get_method_child($id) {
        $list_method = $this->m_method->get_many_by(['risk_id' => $id]);
        echo json_encode([
            'state' => 1,
            'data'  => $list_method,
        ]);
    }
}
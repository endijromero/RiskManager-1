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
            "object" => "Conflict",
        );
    }

    public function create($parent_value, $data = Array(), $data_return = Array()) {
        $id = $parent_value;
        $data['list_risk'] = $this->m_risk->get_many_by(['project_id' => $id]);
        $data["view_file"] = $this->name['view'] . '/conflict_add_form';
        return parent::create($parent_value, $data, $data_return);
    }

    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
//        if ($data['code'] == NULL  || $data['method_1_id'] == NULL || $data['method_2_id'] == NULL ) {
        if ( $data['method_1_id'] == NULL || $data['method_2_id'] == NULL ) {
            echo json_encode([
                'state' => 0,
                'msg'   => 'Invalid data!
                Don\'t leave the inputs empty.',
            ]);;
            return 0;
        }
        $method_record_1 = $this->m_method->get($data['method_1_id']);
        $method_record_2 = $this->m_method->get($data['method_2_id']);
        $risk_id_1 = $method_record_1->risk_id;
        $risk_id_2 = $method_record_2->risk_id;
        if (($data['method_2_id'] == $data['method_1_id']) || $risk_id_1 == $risk_id_2) {
            echo json_encode([
                'state' => 0,
                'msg'   => 'Invalid data!
                You must choose two RiskResponce of two different Risks.',
            ]);;
            return 0;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

    public function get_method_child($id) {
        $list_method = $this->m_method->get_many_by(['risk_id' => $id]);
        echo json_encode([
            'state' => 1,
            'data'  => $list_method,
        ]);
    }
    public function edit_save($id = 0, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "save_form_edit_response";
        }
        if (sizeof($data) == 0) {
            $data = $this->input->post();
        }
        $data_return = $this->_precheck_post_data($data, $data_return);
        if ($data_return['state'] != 1) {
            $data_return["data"] = $data;
            echo json_encode($data_return);
            return FALSE;
        } else {
            return parent::edit_save($id, $data, $data_return, $skip_validate);
        }
    }
    private function _precheck_post_data($data, $data_return = Array()) {
        if (($data['method_2_id'] == $data['method_1_id'])) {
            $data_return['state'] = 0;
            $data_return['msg'] = 'Invalid data!
                You must choose two RiskResponce of two different Risks.';
        } else {
            $data_return['state'] = 1;
        }
//        $data_return['state'] = 1;
        return $data_return;
    }
}
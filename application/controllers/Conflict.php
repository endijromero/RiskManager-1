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
    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['code'] == null  || $data['name']==null ||$data['method_1_id'] ==null || $data['method_2_id'] ==null || $data['description'] ==null)
        {
            echo json_encode([
                'state' => 0,
                'msg' => 'Dữ liệu không hợp lệ!
                Cần nhập đầy đủ thông tin các trường.',
            ]);;
            return 0;
        }
        $method_record_1 = $this->m_method->get($data['method_1_id']);
        $method_record_2 = $this->m_method->get($data['method_2_id']);
        $risk_id_1 = $method_record_1->risk_id;
        $risk_id_2 = $method_record_2->risk_id;
        if(($data['method_2_id'] == $data['method_1_id'])||$risk_id_1==$risk_id_2 ) {
            echo json_encode([
                'state' => 0,
                'msg' => 'Dữ liệu không hợp lệ!
                Bạn phải chọn 2 phương thức của 2 rủi ro khác nhau.',
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
}
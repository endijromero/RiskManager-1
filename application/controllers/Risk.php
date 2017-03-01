<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Risk
 *
 * @property M_risk model
 */
class Risk extends Abs_child_manager {
    protected $_parent_field = 'project_id';
    public function __construct() {
        parent::__construct();
        $this->load_more_css("assets/css/font/detail.css");
        $this->load_more_js("assets/js/front/risk.js");
        $this->load->model('m_risk_type');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "risk",
            "view"   => "risk",
            "model"  => "m_risk",
            "object" => "Rủi Ro",
        );
    }
    public function create($parent_value, $data = Array(), $data_return = Array()) {
        $id = $parent_value;
        $data['list_risk_type'] = $this->m_risk_type->get_many_by(['project_id' => $id]);
        $data["view_file"] = $this->name['view'] . '/risk_add_form';
        return parent::create($parent_value, $data, $data_return);
    }

    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['risk_type_id']==null ||$data['code']==null ||$data['name']==null || $data['description'] ==null)
        {
            echo json_encode([
                'state' => 0,
                'msg' => 'Dữ liệu không hợp lệ!
                Cần nhập đầy đủ thông tin các trường.',
            ]);;
            return 0;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }
    public function manage($parent_value, $data = Array()) {
        $data['toolbar'] = '<div class="widget-toolbar actions_content e_actions_content">
                <a href="' . site_url('conflict/manage/' . $parent_value) . '" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-leaf"></i>
                    Quản lý xung đột
                </a>
            </div>';
        parent::manage($parent_value, $data);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="' . site_url('risk/detail/' . $record->id) . '">' . $origin_column_value . '</a>';
    }

    function detail($id) {
        $data['detail_risk'] = $this->model->get($id);
        $data['risk_id']=$id;
        $content = $this->load->view("admin/font/risk_detail", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }
}
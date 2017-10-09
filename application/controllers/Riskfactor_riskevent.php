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
class Riskfactor_riskevent extends Abs_child_manager {
    protected $_parent_field = 'project_id';
    public function __construct() {
        parent::__construct();
        $this->load_more_css("assets/css/font/detail.css");
        $this->load_more_js("assets/js/front/risk.js");
        $this->load->model('m_risk_factor');
        $this->load->model('m_risk');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "riskfactor_riskevent",
            "view"   => "riskfactor_riskevent",
            "model"  => "m_riskfactor_riskevent",
            "object" => "Risk Factor - Risk event",
        );
    }
    public function create($parent_value, $data = Array(), $data_return = Array())
    {
        $data['list_risk_factor'] = $this->m_risk_factor->get_all();
        $data['list_risk'] = $this->m_risk->get_all();
        $data["view_file"] = $this->name['view'] . '/riskfactor_riskevent_add_form';
        return parent::create($parent_value, $data, $data_return);
    }

    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['code']==null ||$data['risk_factor_id']==null || $data['risk_id'] ==null)
        {
            echo json_encode([
                'state' => 0,
                'msg' => 'Invalid data!
                Don\'t leave the inputs empty.',
            ]);;
            return 0;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

   /*  public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="' . site_url('risk_factor/detail/' . $record->id) . '">' . $origin_column_value . '</a>';
    }

    function detail($id) {
        $data['detail_risk_factor'] = $this->model->get($id);
        $data['risk_factor_id']=$id;
        $content = $this->load->view("admin/font/risk_factor_detail", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    } */
}
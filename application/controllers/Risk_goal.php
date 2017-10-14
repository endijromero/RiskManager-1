<?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 09/10/2017
 * Time: 10:57
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Risk_goal
 *
 * @property M_risk_goal model
 */
class Risk_goal extends Abs_child_manager {
    protected $_parent_field = 'project_id';
    public function __construct() {
        parent::__construct();
//        $this->load_more_css("assets/css/font/detail.css");
//        $this->load_more_js("assets/js/front/risk.js");
        $this->load->model('m_risk');
        $this->load->model('m_goal');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "risk_goal",
            "view"   => "risk_goal",
            "model"  => "m_risk_goal",
            "object" => "Risk - Goal",
        );
    }
    public function create($parent_value, $data = Array(), $data_return = Array())
    {
        $data['list_goal'] = $this->m_goal->get_all();
        $data['list_risk'] = $this->m_risk->get_all();
        $data["view_file"] = $this->name['view'] . '/risk_goal_add_form';
        return parent::create($parent_value, $data, $data_return);
    }

    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['code']==null ||$data['goal_id']==null || $data['risk_id'] ==null)
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

}
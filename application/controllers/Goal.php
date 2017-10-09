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
class Goal extends Abs_child_manager {
    protected $_parent_field = 'project_id';
    public function __construct() {
        parent::__construct();
        $this->load_more_css("assets/css/font/detail.css");
        $this->load_more_js("assets/js/front/risk.js");
        $this->load->model('m_goal_type');
        $this->load->model('m_goal');
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "goal",
            "view"   => "goal",
            "model"  => "m_goal",
            "object" => "Goal",
        );
    }
    public function add_save($data = Array(), $data_return = Array(), $skip_validate = TRUE){
        if(!$data['parent_goal_id']) unset($data['parent_goal_id']);
        parent::add_save($data, $data_return, FALSE);
    }
    public function create($parent_value, $data = Array(), $data_return = Array()) {
        $data['list_goal_type'] = $this->m_goal_type->get_all();
        $data['list_goal'] = $this->m_goal->get_all();
        $data["view_file"] = $this->name['view'] . '/goal_add_form';
        return parent::create($parent_value, $data, $data_return);
    }
    public function get_method_child() {
        $list_method = $this->m_goal_type->getall();
        echo json_encode([
            'state' => 1,
            'data'  => $list_method,
        ]);
    }
    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['goal_type_id']==null ||$data['code']==null ||$data['name']==null || $data['description'] ==null||$data['goal_level'] ==null )
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

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="' . site_url('goal/detail/' . $record->id) . '">' . $origin_column_value . '</a>';
    }

    function detail($id) {
        $data['detail_goal'] = $this->model->get($id);
        $data['goal_id']=$id;
        $content = $this->load->view("admin/font/goal_detail", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }
}
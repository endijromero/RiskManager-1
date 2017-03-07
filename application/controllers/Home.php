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
            "object" => "Dự Án",
        );
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
                'msg'   => 'Dữ liệu không hợp lệ!
                Cần nhập đầy đủ thông tin các trường.',
            ]);;
            return 0;
        }
        return $this->add_save($data, $data_return, $skip_validate);
    }

}
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

    public function setting_class() {
        $this->name = Array(
            "class"  => "risk",
            "view"   => "risk",
            "model"  => "m_risk",
            "object" => "Rủi Ro",
        );
    }

    public function manage($project_id, $data = Array()) {
        $data['toolbar'] = '<div class="widget-toolbar actions_content e_actions_content">
                <a href="' . site_url('conflict/manage/' . $project_id) . '" class="btn btn-success btn-sm">
                    <i class="ace-icon fa fa-leaf"></i>
                    Quản lí xung đột
                </a>
            </div>';
        parent::manage($project_id, $data);
    }

    public function add_link($origin_column_value, $column_name, &$record, $column_data, $caller) {
        return '<a href="risk/detail/' . $record->id . '">' . $origin_column_value . '</a>';
    }

    function detail($id) {
        $data['detail_risk'] = $this->model->get($id);
        $content = $this->load->view("admin/font/risk_detail", $data, TRUE);
        $this->load_more_css("assets/css/font/detail.css");
        $this->show_page($content);
    }
}
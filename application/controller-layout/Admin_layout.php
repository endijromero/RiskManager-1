<?php
/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 3/17/16
 * Time: 11:16
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Admin_layout extends Base_layout {

    protected $role_allow = 'admin';

    function __construct() {
        parent::__construct();
        $this->_set_side_bar_left();
        $this->_set_top_bar();
        $this->check_role();
    }

    private function _set_side_bar_left() {
        $menu[] = Array(
            "text" => "List of Projects",
            "icon" => "fa-dashboard",
            "url"  => site_url('home'),
        );

        $project_id = $this->session->userdata('project_id');
        if ($project_id) {
            //TODO:
            $project_menu[] = Array(
                "text" => "Goal Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('goal/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Risk factor Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('risk_factor/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Risk Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('risk/manage/' . $project_id),
            );

            $project_menu[] = Array(
                "text" => "Risk Factor-Risk event Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('riskfactor_riskevent/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Risk-Goal Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('risk_goal/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Conflict Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('conflict/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Weighted fitness function Management",
                "icon" => "fa-dashboard",
                "url"  => site_url('fitness/manage/' . $project_id),
            );
            $project_menu[] = Array(
                "text" => "Request for help make decisions",
                "icon" => "fa-dashboard",
                "url"  => site_url('hint/manage/' . $project_id),
            );
            $menu[] = Array(
                "text"  => "Project Management",
                "icon"  => "fa-table",
                "url"   => site_url('hint/manage/' . $project_id),
                "child" => $project_menu,
            );
        }
        $menu[] = Array(
            "text" => "Agent Manager ",
            "icon" => "fa fa-pied-piper",
            "url"  => site_url('agent_manager'),
        );
        $menu[] = Array(
            "text" => "Goal Category ",
            "icon" => "fa fa-pied-piper",
            "url"  => site_url('goal_type'),
        );
        $menu[] = Array(
            "text" => "Risk Category ",
            "icon" => "fa fa-pied-piper",
            "url"  => site_url('risk_type'),
        );
        $menu[] = Array(
            "text" => "Finished projects",
            "icon" => "fa fa-list",
            "url"  => site_url('finished_project '),
        );
        $menu[] = Array(
            "text" => "User",
            "icon" => "fa-users",
            "url"  => site_url('user'),
        );

        $data = Array(
            'view_file' => "admin/base_layout/side_bar_left",
            'menu_data' => $menu,
        );
        $this->set_data_part('side_bar_left', $data, TRUE);
    }

    private function _set_top_bar() {
        $data = Array(
            'view_file' => "admin/base_layout/top_bar",
        );
        $this->set_data_part('top_bar', $data, TRUE);
    }

    protected function check_role() {
        return TRUE;
        if (!$this->ion_auth->logged_in()) {
            $this->redirect_to_login();
        }
        if (!$this->ion_auth->in_group($this->role_allow)) {
            $this->ion_auth->logout();
            $this->redirect_to_login();
        }
    }

    protected function redirect_to_login() {
        $login_link = site_url("admin/login");
        $this->session->set_userdata('redirect_login', current_url());
        $this->session->set_flashdata("msg", "<div class='alert alert-warning'>Required login!</div>");
        redirect($login_link);
    }
}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Risk_type
 */
class Risk_type extends Manager_base {
    public function __construct() {
        parent::__construct();
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "risk_type",
            "view"   => "risk_type",
            "model"  => "m_risk_type",
            "object" => "Risk Category",
        );
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
        if($data['code']==null ||$data['name']==null || $data['description'] ==null)
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
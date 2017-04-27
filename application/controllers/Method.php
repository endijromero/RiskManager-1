<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Method
 *
 * @property M_method model
 */
class Method extends Abs_child_manager {
    protected $_parent_field = 'risk_id';

    public function setting_class() {
        $this->name = Array(
            "class"  => "method",
            "view"   => "method",
            "model"  => "m_method",
            "object" => "Risk Response",
        );
    }
    public function create_save($parent_value, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (sizeof($data) == 0) {
            $data = $this->input->post();
            $data[$this->_parent_field] = $parent_value;
        }
        if($data['code']==null ||$data['name']==null ||$data['cost']==null ||$data['diff']==null ||$data['priority']==null || $data['time']==null ||$data['description'] ==null)
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
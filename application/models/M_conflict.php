<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_conflict extends Abs_child_model {
    public $_parent_field = 'project_id';
    protected $_table = 'conflicts';
    protected $before_dropdown = array();
    public $schema = [
        'project_id'   => [
            'field' => 'project_id',
            'label' => 'Project ID',
            'rules' => '',
        ],
        'project_code' => [
            'field'    => 'project_code',
            'label'    => 'Project code',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'code'         => [
            'field'  => 'code',
            'label'  => 'Conflict code',
//            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'method_1_id'  => [
            'field'    => 'method_1_id',
            'db_field' => 'method_1_id',
            'label'    => 'Risk Responce 1 code',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_method',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id', 'code'],
            ],
        ],
        'method_2_id'  => [
            'field'    => 'method_2_id',
            'db_field' => 'method_2_id',
            'label'    => 'Risk Responce 2 code',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_method',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id', 'code'],
            ],
        ],

        'method_1_code' => [
            'field'    => 'method_1_code',
            'db_field' => 'method_1_code',
            'label'    => 'Risk Responce 1 code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'method_2_code' => [
            'field'    => 'method_2_code',
            'db_field' => 'method_2_code',
            'label'    => 'Risk Responce 2 code',
            'rules'    => '',
            'table'    => TRUE,
        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get'] = 'default_before_get';
    }

    public function default_before_get() {
        $this->db->select($this->_table_alias . '.*, p.code as project_code,CONCAT(c1.code," (","Risk",c1.risk_id,")") as method_1_code,CONCAT(c2.code," (","Risk",c2.risk_id,")") as method_2_code');
        $this->db->join('projects as p', 'p.deleted=0 AND p.id=m.project_id');
        $this->db->join('methods as c1', 'c1.deleted=0 AND c1.id=m.method_1_id');
        $this->db->join('methods as c2', 'c2.deleted=0 AND c2.id=m.method_2_id');
    }

}
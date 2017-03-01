<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_risk_type extends Abs_child_model {
    protected $_parent_field = 'project_id';
    protected $_table = 'risk_types';
    public $schema = [
        'project_id'      => [
            'field'    => 'project_id',
            'label'    => 'id dự án',
            'db_field' => 'project_id',
            'rules'    => '',
//            'filter'   => [
//                'type' => 'text',
//            ],
        ],
        'project_code'    => [
            'field'    => 'project_code',
            'label'    => 'Mã dự án',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'code' => [
            'field'  => 'code',
            'label'  => 'Mã loại rủi ro',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Tên loại rủi ro',
            'rules'    => 'required',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],

        'description' => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'createdAt'   => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get']='default_before_get';
    }

    public function default_before_get(){
        $this->db->select($this->_table_alias.'.*, p.code as project_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
    }
}
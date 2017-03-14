<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_risk extends Abs_child_model {
    protected $_parent_field = 'project_id';
    protected $_table = 'risks';
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'id dự án',
            'rules'    => 'required',
        ],
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Mã dự án',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'risk_type_id'    => [
            'field'  => 'risk_type_id',
            'label'  => 'id loại rủi ro',
            'db_field' => 'risk_type_id',
            'rules'  => '',
//            'form'   => [
//                'type' => 'number',
//            ],


        ],
        'risk_type_id'  => [
            'field'    => 'risk_type_id',
            'db_field' => 'risk_type_id',
            'label'    => 'Mã loại rủi ro',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_risk_type',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id', 'code'],
            ],
        ],
        'risk_type_code'    => [
            'field'    => 'risk_type_code',
            'label'    => 'Mã loại rủi ro',
            'rules'  => 'required',
            'db_field' => 'risk_type_code',
//            'form'   => [
//                'type' => 'text',
//            ],
            'table'    => TRUE,

        ],
        'code'            => [
            'field'  => 'code',
            'label'  => 'Mã rủi ro',
            'rules'  => 'required',
            'form'   => [
                'type' => 'text',
            ],
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'name'            => [
            'field'  => 'name',
            'label'  => 'Tên rủi ro',
            'rules'  => '',
            'form'   => [
                'type' => 'text',
            ],
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'method_quantity' => [
            'field' => 'method_quantity',
            'db_field' => 'method_quantity',
            'label' => 'Số phương án xử lí',
            'rules' => '',
//            'form'   => [
//                'type' => 'text',
//            ],
            'table' => TRUE,
        ],
        'description'     => [
            'field' => 'description',
//            'db_field' => 'description',
            'label' => 'Mô tả',
            'rules' => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table' => TRUE,
        ],
        'createdAt'       => [
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
        $this->db->select($this->_table_alias.'.*, p.code as project_code, r.code as risk_type_code,count(me .id) as method_quantity');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('risk_types as r', 'r.deleted=0 AND r.id=m.risk_type_id');
        $this->db->group_by('m.id');
        $this->db->join('methods as me', 'me.deleted=0 AND me.risk_id=m.id', 'LEFT');
    }

}
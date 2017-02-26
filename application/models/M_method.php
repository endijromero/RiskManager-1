<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_method extends Abs_child_model {
    protected $_parent_field = 'risk_id';
    protected $_table = 'methods';
    public $schema = [
        'risk_id'     => [
            'field'    => 'risk_id',
            'db_field' => 'risk_id',
            'label'    => 'id rủi ro',
            'rules'    => '',
//            'filter'   => [
//                'type' => 'text',
//            ],
        ],
        'risk_code'   => [
            'field'    => 'risk_code',
            'db_field' => 'risk_code',
            'label'    => 'Mã rủi ro',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'code'        => [
            'field'  => 'code',
            'label'  => 'Mã phương pháp',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name'        => [
            'field'    => 'name',
            'db_field' => 'name',
            'label'    => 'Tên phương pháp',
            'rules'    => '',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => FALSE,
        ],
        'cost'        => [
            'field'    => 'cost',
            'db_field' => 'cost',
            'label'    => 'Chi phí',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
            ],
            'table'    => TRUE,
        ],
        'diff'        => [
            'field'    => 'diff',
            'db_field' => 'diff',
            'label'    => 'Độ khó',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
            ],
            'table'    => TRUE,
        ],
        'priority'    => [
            'field'    => 'priority',
            'db_field' => 'priority',
            'label'    => 'Độ ưu tiên',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
            ],
            'table'    => TRUE,
        ],
        'time'        => [
            'field'    => 'time',
            'db_field' => 'time',
            'label'    => 'Thời gian xử lí - giờ',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
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
        $this->before_get['default_before_get'] = 'default_before_get';
    }

    public function default_before_get() {
        $this->db->select($this->_table_alias . '.*, r.id as risk_id, r.code as risk_code,r.name as risk_name,
                          p.id as project_id, p.name as project_name');
        $this->db->join('risks as r', 'r.deleted=0 AND r.id=m.risk_id');
        $this->db->join('projects as p', 'p.deleted=0 AND p.id=r.project_id');
    }
}
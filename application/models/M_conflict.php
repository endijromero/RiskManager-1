<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_conflict extends Abs_child_model {
    protected $_table = 'conflicts';
    public $_parent_field = 'project_id';
    public $schema = [
        'project_id'      => [
            'field'    => 'project_id',
            'label'    => 'id dự án',
//            'db_field' => 'project_id',
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
        'code'        => [
            'field'    => 'code',
            'db_field' => 'name',
            'label'    => 'Mã xung đột',
            'rules'    => '',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'name'        => [
            'field'    => 'name',
            'db_field' => 'risk_quantity',
            'label'    => 'Tên xung đột',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
        ],
        'description' => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'method_1_code' => [
            'field'    => 'method_1_code',
            'db_field' => 'method_1_code',
            'label'    => 'Mã phương pháp 1',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'method_2_code' => [
            'field'    => 'method_2_code',
            'db_field' => 'method_2_code',
            'label'    => 'Mã phương pháp 2',
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
        $this->db->select($this->_table_alias.'.*, p.code as project_code,c1.code as method_1_code,c2.code as method_2_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('methods as c1', 'c1.deleted=0 AND c1.id=m.method_1_id');
        $this->db->join('methods as c2', 'c2.deleted=0 AND c2.id=m.method_2_id');
    }
}
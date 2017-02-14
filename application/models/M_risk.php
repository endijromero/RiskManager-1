<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_risk extends Crud_manager {
    protected $_table = 'risks';
    public $schema = [
        'project_id	'   => [
            'field'    => 'project_id',
            'label'    => 'Mã dự án',
            'db_field' => 'project_id',
            'rules'    => 'required',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'risk_type_id	' => [
            'field'    => 'risk_type_id',
            'label'    => 'Loại rủi ro',
            'db_field' => 'risk_type_id',
            'rules'    => 'required',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'code'             => [
            'field'  => 'code',
            'label'  => 'Mã rủi ro',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name'             => [
            'field'    => 'name',
            'db_field' => 'name',
            'label'    => 'Tên rủi ro',
            'rules'    => '',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'description'      => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'createdAt'        => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
    ];

    public function __construct() {
        parent::__construct();
//        $this->before_get['join_all'] = "join_user_table";
    }
}
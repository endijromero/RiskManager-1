<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_conflict extends Abs_child_model {
    protected $_table = 'conflicts';
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'Mã dự án',
            'db_field' => 'project_id',
            'rules'    => 'required',
            'filter'   => [
                'type' => 'text',
            ],
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
        ],
        'description' => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'method_1_id' => [
            'field'    => 'method_1_id',
            'db_field' => 'method_1_id',
            'label'    => 'Phương pháp 1',
            'rules'    => '',
            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'method_2_id' => [
            'field'    => 'method_2_id',
            'db_field' => 'method_2_id',
            'label'    => 'Phương pháp 2',
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
}
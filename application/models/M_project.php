<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_project extends Crud_manager
{
    protected $_table = 'projects';
    public $schema = [
        'code' => [
            'field' => 'code',
            'label' => 'Mã dự án',
            'rules' => 'required',
            'form' => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table' => TRUE,
        ],
        'name' => [
            'field' => 'name',
            'db_field' => 'name',
            'label' => 'Tên dự án',
            'rules' => 'required',
            'form' => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table' => TRUE,
        ],
        'description' => [
            'field' => 'description',
            'db_field' => 'description',
            'label' => 'Mô tả',
            'rules' => '',
            'form' => TRUE,
            'table' => TRUE,
        ],
        'createdAt' => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
    ];

    public function __construct()
    {
        parent::__construct();
//        $this->before_get['join_all'] = "join_user_table";
    }
}
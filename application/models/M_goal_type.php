<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_goal_type extends Crud_manager  {
    protected $_table = 'goal_categories';
    public $schema = [
        'code' => [
            'field'  => 'code',
            'label'  => 'Goal category code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Goal category name',
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
            'label'    => 'Description',
            'rules'    => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table'    => TRUE,
        ],
    ];

    public function __construct() {
        parent::__construct();
    }

}
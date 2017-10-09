<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_risk_type extends Crud_manager  {
    protected $_table = 'risk_types';
    public $schema = [
        'code' => [
            'field'  => 'code',
            'label'  => 'Risk category code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Risk category name',
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
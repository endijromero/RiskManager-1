<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_fitness extends Abs_child_model {
    protected $_parent_field = 'project_id';
    protected $_table = 'fitness';
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'Project ID',
            'db_field' => 'project_id',
            'rules'    => 'required',

        ],
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Project code',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'cost'    => [
            'field'  => 'cost',
            'label'  => 'Cost weighting',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder'    => 'Cost weighting(number)',
            ],
            'table' => TRUE,
        ],
        'diff'    => [
            'field'  => 'diff',
            'label'  => 'Difficulty weighting',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Difficulty weighting(number)"
            ],
            'table' => TRUE,
        ],
        'priority'    => [
            'field'  => 'priority',
            'label'  => 'Priority weighting',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Priority weighting(number)"
            ],
            'table' => TRUE,
        ],
        'time'    => [
            'field'  => 'time',
            'label'  => 'Time weighting',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Time weighting(number)"
            ],
            'table' => TRUE,
        ],
//        'createdAt'       => [
//            'field' => 'createdAt',
//            'label' => 'Ngày tạo',
//            'rules' => '',
//            'table' => FALSE,
//        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get'] = 'default_before_get';
    }

    public function default_before_get() {
        $this->db->select($this->_table_alias.'.*, p.code as project_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
    }
}
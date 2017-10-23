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
    protected $before_dropdown = array();
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'Project ID',
            'rules'    => 'required',
        ],
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Project code',
            'db_field' => 'project_code',
            'rules'    => ''
        ],
        'code'            => [
            'field'  => 'code',
            'label'  => 'Risk code',
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
            'label'  => 'Risk name',
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
        'risk_type_code'    => [
            'field'    => 'risk_type_code',
            'db_field' => 'risk_type_code',
            'label'    => 'Risk category code',
            'rules'  => '',

        ],
        'method_quantity' => [
            'field' => 'method_quantity',
            'db_field' => 'method_quantity',
            'label' => 'Quantity of Risk Response',
            'rules' => '',
            'table' => TRUE,
        ],
        'description'     => [
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table' => TRUE,
        ],
        'financial_impact'     => [
            'field' => 'financial_impact',
            'rules'  => 'required',
            'label' => 'Financial impact($)',
            'rules' => '',
            'form'     => [
                'type' => 'number',
                'placeholder'    => 'Financial_impact (usd)',
            ],
            'table' => TRUE,
        ],
        'risk_level'  => [
            'field'    => 'risk_level',
            'rules'  => 'required',
            'label'    => 'Risk level',
            'rules'    => '',
            'form'     => Array(
                'type'            => 'select',
                'target_model'    => 'this',
                'target_function' => 'get_role',
                'class'           => '',
            ),
            'table'    => Array(
                'callback_render_data' => "get_risk_level",
            )
        ],
        'risk_type_id'  => [
            'field'    => 'risk_type_id',
            'db_field' => 'risk_type_id',
            'label'    => 'Risk category code',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_risk_type',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id','code'],
            ],

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

    public function get_role() {
        return [
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            'Extreme' => 'Extreme',
        ];
    }


    public function get_risk_level($id) {
        $status = $this->get_role();
        if (isset($status[$id])) {
            return $status[$id];
        } else {
            return $id;
        }
    }
}
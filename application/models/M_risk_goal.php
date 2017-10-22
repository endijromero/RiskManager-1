<?php
/**
 * Created by PhpStorm.
 * User: taohansamu
 * Date: 09/10/2017
 * Time: 11:02
 */
class M_risk_goal extends Abs_child_model  {
    protected $_parent_field = 'project_id';
    protected $_table = 'risk-goal';
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'Project ID',
            'rules'    => 'required',
        ],
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Project Code',
            'db_field' => 'project_code',
            'rules'    => ''
        ],
        'code'      => [
            'field'    => 'code',
            'label'    => 'Code',
            'rules'    => 'required',
            'filter' => [
                'type' => 'text',
            ],
            'form'   => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],

        'risk_code'      => [
            'field'    => 'risk_code',
            'label'    => 'Risk Code',
            'db_field' => 'r.code',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'risk_id'  => [
            'field'    => 'risk_id',
            'label'    => 'risk ID',
            'rules'    => 'required',
        ],
        'goal_id'  => [
            'field'    => 'goal_id',
            'label'    => 'goal ID',
            'rules'    => 'required',
        ],
        'goal_code'      => [
            'field'    => 'goal_code',
            'label'    => 'Goal Code',
            'db_field' => 'g.code',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],'table'  => [
                'callback_render_data' => "add_link",
            ]
        ],
        'description'      => [
            'field'    => 'description',
            'label'    => 'Description',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'form'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get']='default_before_get';
    }

    public function default_before_get(){
        $this->db->select($this->_table_alias.'.*, p.code as project_code, g.code as goal_code, r.code as risk_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('goals as g','g.deleted=0 AND g.id=m.goal_id');
        $this->db->join('risks as r','r.deleted=0 AND r.id=m.risk_id');
        $this->db->group_by('m.id');
    }

}
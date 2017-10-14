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
            'db_field' => 'code',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'form'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'description'      => [
            'field'    => 'description',
            'label'    => 'Description',
            'db_field' => 'description',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'form'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'risk_code'      => [
            'field'    => 'risk_code',
            'label'    => 'Risk Code',
            'db_field' => 'risk_code',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'table'    => TRUE,
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
            'db_field' => 'goal_code',
            'rules'    => '',
            'filter' => [
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
        $this->db->select($this->_table_alias.'.*, p.code as project_code, g.code as goal_code, r.code as risk_code, g.id as goal_id, r.id as risk_id');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('goals as g','g.deleted=0 AND g.id=m.goal_id');
        $this->db->join('risks as r','r.deleted=0 AND r.id=m.risk_id');
//        $this->db->group_by('m.id');
    }

}
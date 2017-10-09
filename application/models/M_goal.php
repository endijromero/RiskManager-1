<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_goal extends Abs_child_model {
    protected $_parent_field = 'project_id';
    protected $_table = 'goals';
    protected $before_dropdown = array();
//    protected $soft_delete = FALSE;
    public $schema = [
        'project_id'  => [
            'field'    => 'project_id',
            'label'    => 'Project ID',
            'rules'    => 'required',
        ],
        'code'            => [
            'field'  => 'code',
            'label'  => 'Goal code',
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
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Project code',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'goal_type_id'  => [
            'field'    => 'goal_type_id',
            'db_field' => 'goal_type_id',
            'label'    => 'Goal type id',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_goal_type',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id','code'],
            ]

        ],
        'goal_type_code'    => [
            'field'    => 'goal_type_code',
            'db_field' => 'goal_type_code',
            'label'    => 'Goal category code',
            'rules'  => '',
            'table'    => TRUE,

        ],
        'name'            => [
            'field'  => 'name',
            'label'  => 'Goal name',
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
        'description'     => [
            'field' => 'description',
            'label' => 'Description',
            'rules' => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table' => TRUE,
        ],
        'goal_level'  => [
            'field'    => 'goal_level',
            'rules'  => 'required',
            'label'    => 'Goal level',
            'rules'    => '',
            'form'     => Array(
                'type'            => 'select',
                'target_model'    => 'this',
                'target_function' => 'get_role',
                'class'           => '',
            ),
            'table'    => Array(
                'callback_render_data' => "get_goal_level",
            ),
            'table' => TRUE,
        ],
        'parent_goal_id'  => [
            'field'    => 'parent_goal_id',
            'db_field' => 'parent_goal_id',
            'label'    => 'Parent goal code',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_goal',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id','code'],
            ]
        ],
        'parent_goal_code'    => [
            'field'    => 'parent_goal_code',
            'db_field' => 'parent_goal_code',
            'label'    => 'Parent goal code',
            'rules'  => '',
            'table'    => TRUE,

        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get']='default_before_get';
        $this->after_delete['default_after_delete'] = 'default_after_delete';
    }

    public function default_before_get(){
        $this->db->select($this->_table_alias.'.*, p.code as project_code, g.code as goal_type_code, pg.code as parent_goal_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('goal_categories as g', 'g.deleted=0 AND g.id=m.goal_type_id');
        $this->db->join('goals as pg', 'pg.id=m.parent_goal_id', 'left');
        $this->db->group_by('m.id');
    }
    public function default_after_delete($id){
        $this->db->set('deleted', 1);
        $this->db->where('parent_goal_id', $id);
        $this->db->update('goals');
    }
    public function get_role() {
        return [
            'Low' => 'Low',
            'Medium' => 'Medium',
            'High' => 'High',
            'Extreme' => 'Extreme',
        ];
    }


    public function get_goal_level($id) {
        $status = $this->get_role();
        if (isset($status[$id])) {
            return $status[$id];
        } else {
            return $id;
        }
    }
}
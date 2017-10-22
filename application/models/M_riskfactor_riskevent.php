<?php
class M_riskfactor_riskevent extends Abs_child_model  {
    protected $_parent_field = 'project_id';
    protected $_table = 'riskfactor-riskevent';
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
            'rules'    => '',
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
        'risk_factor_id'  => [
            'field'    => 'risk_factor_id',
            'label'    => 'risk_factor ID',
            'rules'    => 'required',
        ],
        'risk_factor_code'      => [
            'field'    => 'risk_factor_code',
            'label'    => 'Risk Factor Code',
            'db_field' => 'rf.code',
            'rules'    => '',
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'description'      => [
            'field'    => 'description',
            'label'    => 'Description',
            'db_field' => 'description',
            'rules'    => '',
            'form'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
    ];

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get']='default_before_get';
//        $this->before_create['default_before_create']='default_before_create';
    }

    /*public function default_before_create($data)
    {
        var_dump($data);
        return TRUE;
    }*/
    public function default_before_get(){
        $this->db->select($this->_table_alias.'.*, p.code as project_code, rf.code as risk_factor_code, r.code as risk_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->join('risk_factors as rf','rf.deleted=0 AND rf.id=m.risk_factor_id');
        $this->db->join('risks as r','r.deleted=0 AND r.id=m.risk_id');
        $this->db->group_by('m.risk_id');
    }

}
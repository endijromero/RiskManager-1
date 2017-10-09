<?php
class M_risk_factor extends Abs_child_model  {
    protected $_parent_field = 'project_id';
    protected $_table = 'risk_factors';
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
            'rules'    => '',
            'table'    => TRUE,
        ],
        'code' => [
            'field'  => 'code',
            'label'  => 'Risk factor code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Risk factor name',
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
        $this->before_get['default_before_get']='default_before_get';
    }

    public function default_before_get(){
        $this->db->select($this->_table_alias.'.*, p.code as project_code');
        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
        $this->db->group_by('m.id');
    }

}
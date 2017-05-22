<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_project extends Crud_manager {
    protected $_table = 'projects';
    public $schema = [
        'user_id'       => [
            'field' => 'user_id',
            'db_field' => 'user_id',
            'label' => 'User ID',

        ],
        'code'          => [
            'field'  => 'code',
            'label'  => 'Project code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],

        ],
        'name'          => [
            'field'  => 'name',
            'label'  => 'Project name',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'risk_quantity' => [
            'field'    => 'risk_quantity',
            'db_field' => 'risk_quantity',
            'label'    => 'Quantity of risk',
            'rules'    => '',
//            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'description'   => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Description',
            'rules'    => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table'    => TRUE,
        ],

        'project_id'    => [
            'field'    => 'project_id',
            'db_field' => 'r.id',
            'label'    => 'Project ID',
            'rules'    => '',
        ],
    ];

    private $_allowed_status = '';

    public function __construct() {
        parent::__construct();
        $this->before_get['default_before_get'] = 'default_before_get';
    }

    public function default_before_get() {
        $this->db->select($this->_table_alias . '.*, count(r.id) as risk_quantity');
        $this->db->group_by('m.id');
        $this->db->join('risks as r', 'r.deleted=0 AND r.project_id=m.id', 'LEFT');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        if ($this->_allowed_status) {
            $this->db->where('finished', $this->_allowed_status == 'finished' ? '1' : '0');
        }
    }

    public function set_allowed_status($allowed_status) {
        $this->_allowed_status = $allowed_status;
    }
}
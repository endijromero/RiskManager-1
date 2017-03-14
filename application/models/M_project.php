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
            'label' => 'id người dùng',

        ],
        'code'          => [
            'field'  => 'code',
            'label'  => 'Mã dự án',
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
            'label'  => 'Tên dự án',
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
            'label'    => 'Số lượng rủi ro',
            'rules'    => '',
//            'form'     => TRUE,
            'table'    => TRUE,
        ],
        'description'   => [
            'field'    => 'description',
            'db_field' => 'description',
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table'    => TRUE,
        ],
        'createdAt'     => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
        'project_id'    => [
            'field'    => 'project_id',
            'db_field' => 'r.id',
            'label'    => 'id dự án',
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
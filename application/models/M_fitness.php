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
            'label'    => 'id dự án',
            'db_field' => 'project_id',
            'rules'    => 'required',

        ],
        'project_code'      => [
            'field'    => 'project_code',
            'label'    => 'Mã dự án',
            'db_field' => 'project_code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'cost'    => [
            'field'  => 'cost',
            'label'  => 'trọng số chi phí',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder'    => 'Chi phí tiền (usd)',
            ],
            'table' => TRUE,
        ],
        'diff'    => [
            'field'  => 'diff',
            'label'  => 'trọng số độ khó',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Độ khó tăng dần từ 1->5"
            ],
            'table' => TRUE,
        ],
        'priority'    => [
            'field'  => 'priority',
            'label'  => 'trọng số độ ưu tiên',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Độ ưu tiên tăng dần từ 1->5"
            ],
            'table' => TRUE,
        ],
        'time'    => [
            'field'  => 'time',
            'label'  => 'trọng số thời gian',
            'rules'  => '',
            'form'   => [
                'type' => 'number',
                'placeholder' => "Thời gian xử lí (giờ)"
            ],
            'table' => TRUE,
        ],
        'createdAt'       => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
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
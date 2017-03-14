<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_risk_type extends Crud_manager  {
    protected $_table = 'risk_types';
    public $schema = [
        'code' => [
            'field'  => 'code',
            'label'  => 'Mã loại rủi ro',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Tên loại rủi ro',
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
            'label'    => 'Mô tả',
            'rules'    => '',
            'form'     => [
                'type' => 'textarea',
            ],
            'table'    => TRUE,
        ],
        'createdAt'   => [
            'field' => 'createdAt',
            'label' => 'Ngày tạo',
            'rules' => '',
            'table' => FALSE,
        ],
    ];

    public function __construct() {
        parent::__construct();
//        $this->before_get['default_before_get']='default_before_get';
    }

//    public function default_before_get(){
//        $this->db->select($this->_table_alias.'.*, p.code as project_code');
//        $this->db->join('projects as p','p.deleted=0 AND p.id=m.project_id');
//    }
    function custom_dropdown($value_field, $display_field = NULL) {
        $args = func_get_args();
        if (count($args) == 2) {
            list($value_field, $display_field) = $args;
        } else {
            $value_field = $this->primary_key;
            $display_field = $args[0];
        }
        $this->trigger('before_dropdown', array($value_field, $display_field));

        if ($this->soft_delete && $this->_temporary_with_deleted !== TRUE) {
            $this->_database->where($this->_table_alias . "." . $this->soft_delete_key, FALSE);
        }

        $result = $this->_database->get($this->_table . " AS " . $this->_table_alias)
            ->result();
        $options = array();

        foreach ($result as $row) {
            $options[$row->{$value_field}] = $row->{$display_field};
        }

        return $options;
    }
}
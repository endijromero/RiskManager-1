<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_agent extends Crud_manager  {
    protected $_table = 'agents';
    public $schema = [
        'code' => [
            'field'  => 'code',
            'label'  => 'Agent code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name' => [
            'field'    => 'name',
            'label'    => 'Agent name',
            'rules'    => 'required',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => TRUE,
        ],
        'type' => [
            'field'    => 'type',
            'label'    => 'Agent type',
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
    }

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
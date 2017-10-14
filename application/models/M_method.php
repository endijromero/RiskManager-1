<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:19 PM
 */
class M_method extends Abs_child_model {
    protected $_parent_field = 'risk_id';
    protected $_table = 'methods';
    public $schema = [
        'risk_id'     => [
            'field'    => 'risk_id',
            'db_field' => 'risk_id',
            'label'    => 'Risk ID',
            'rules'    => '',
            'filter' =>[
                'search_type'=>'where',
            ],
//            'table'    => TRUE,
        ],
        'risk_code'   => [
            'field'    => 'risk_code',
            'db_field' => 'risk_code',
            'label'    => 'Risk code',
            'rules'    => '',
            'table'    => TRUE,
        ],
        'financial_impact'     => [
            'field'    => 'financial_impact',
            'db_field' => 'financial_impact',
            'label'    => 'Financial_impact',
            'rules'    => '',
//            'table'    => TRUE,
        ],
        'risk_level'   => [
            'field'    => 'risk_level',
            'db_field' => 'risk_level',
            'label'    => 'Risk_level',
            'rules'    => '',
        ],
        'code'        => [
            'field'  => 'code',
            'label'  => 'Risk Response code',
            'rules'  => 'required',
            'form'   => TRUE,
            'filter' => [
                'type' => 'text',
            ],
            'table'  => TRUE,
        ],
        'name'        => [
            'field'    => 'name',
            'label'    => 'Risk Response name',
            'rules'    => '',
            'form'     => TRUE,
            'filter'   => [
                'type' => 'text',
            ],
            'table'    => FALSE,
        ],
        'cost'        => [
            'field'    => 'cost',
            'db_field' => 'cost',
            'label'    => 'Cost',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
                'placeholder'    => 'Cost (usd)',
            ],
            'table'    => TRUE,
        ],
        'diff'        => [
            'field'    => 'diff',
            'db_field' => 'diff',
            'label'    => 'Difficulty',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
                'placeholder' => "Difficulty level increases"
            ],
            'table'    => TRUE,
        ],
        'priority'    => [
            'field'    => 'priority',
            'db_field' => 'priority',
            'label'    => 'Priority',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
                'placeholder' => "Priority level increases"
            ],
            'table'    => TRUE,
        ],
        'time'        => [
            'field'    => 'time',
            'db_field' => 'time',
            'label'    => 'Time',
            'rules'    => '',
            'form'     => [
                'type' => 'number',
                'placeholder' => "Time (hour)"
            ],
            'table'    => TRUE,
        ],
        'responsible_agent_name' => [
            'field'    => 'responsible_agent_name',
            'db_field' => 'responsible_agent_name',
            'label'    => 'Responsible Agent',
            'rules'    => '',
            'form'     => [
                'type'            => 'select',
                'target_model'    => 'M_agent',
                'target_function' => 'custom_dropdown',
                'target_arg'      => ['id','name'],
            ],
            'table'    => TRUE,
        ],
        'action_status' => [
            'field'    => 'action_status',
            'db_field' => 'action_status',
            'label'    => 'Action Status',
            'rules'    => '',
            'form'     => Array(
                'type'            => 'select',
                'target_model'    => 'this',
                'target_function' => 'get_action_status_role',
                'class'           => '',
            ),
            'table'    => Array(
                'callback_render_data' => "get_action_status",
            )
        ],
        'risk_status' => [
            'field'    => 'risk_status',
            'db_field' => 'risk_status',
            'label'    => 'Risk Status',
            'rules'    => '',
            'form'     => Array(
                'type'            => 'select',
                'target_model'    => 'this',
                'target_function' => 'get_risk_status_role',
                'class'           => '',
            ),
            'table'    => Array(
                'callback_render_data' => "get_risk_status",
            )
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
        $this->before_get['default_before_get'] = 'default_before_get';
    }

    public function default_before_get() {
        $this->db->select($this->_table_alias . '.*, r.id as risk_id, r.code as risk_code,r.name as risk_name,r.financial_impact as financial_impact,r.risk_level as risk_level,
                          p.id as project_id, p.name as project_name, a.name as responsible_agent_name');
        $this->db->join('risks as r', 'r.deleted=0 AND r.id = m.risk_id');
        $this->db->join('projects as p', 'p.deleted=0 AND p.id=r.project_id');
        $this->db->join('agents as a', 'a.deleted=0 AND a.id = m.responsible_agent_id');
    }

    function custom_dropdown($value_field, $display_field = NULL) {
        $this->db->select($this->_table_alias . '.*, r.id as risk_id, r.code as risk_code,r.name as risk_name,
                          p.id as project_id, p.name as project_name');
        $this->db->join('risks as r', 'r.deleted=0 AND r.id=m.risk_id');
        $this->db->join('projects as p', 'p.deleted=0 AND p.id=r.project_id');
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
            $options[$row->{$value_field}] = $row->risk_code.' - '.$row->{$display_field};
        }

        $options = $this->trigger('after_dropdown', $options);

        return $options;
    }
    public function get_risk_status_role() {
        return [
            'Zero' => 'Zero',
            'Giam' => 'Giam',
            'Tang' => 'Tang',
            'Hoan_thanh' => 'Hoan_thanh',
        ];
    }
    public function get_action_status_role() {
        return [
            'Chua_bat_dau' => 'Chua_bat_dau',
            'Dang_tien_hanh' => 'Dang_tien_hanh',
            'Da_xong' => 'Da_xong',
            'Huy_bo' => 'Huy_bo',
        ];
    }


    public function get_risk_status($id) {
        $status = $this->get_risk_status_role();
        if (isset($status[$id])) {
            return $status[$id];
        } else {
            return $id;
        }
    }
    public function get_action_status($id) {
        $status = $this->get_action_status_role();
        if (isset($status[$id])) {
            return $status[$id];
        } else {
            return $id;
        }
    }
}
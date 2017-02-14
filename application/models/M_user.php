<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 14/06/16
 * Time: 15:33
 */
class M_user extends Crud_manager {

    protected $_table = 'users';
    public $schema = [
        'email'         => [
            'field'  => 'email',
            'label'  => 'Email',
            'rules'  => 'required|valid_email|is_unique[users.email,deleted=0]|min_length[6]', //As config of Form Validation Class in CodeIngiter
            'errors' => [
                'is_unique' => "Địa chỉ email đã được sử dụng.",
            ],
            'form'   => [
                'type' => 'email',
            ],
            'filter' => [
                'type'        => 'text',
                'search_type' => 'like',
            ],
            'table'  => [
                'callback_render_data' => "add_link",
            ],
        ],
        'name'          => [
            'field'  => 'name',
            'label'  => 'Tên hiển thị',
            'rules'  => 'required',
            'form'   => [
                'type' => 'text',
                'attr' => 'data-test="name"',
            ],
            'filter' => [
                'search_type' => 'like',
                'attr'        => 'data-test="filter"',
            ],
            'table'  => [
                'label' => 'Tên',
            ],
        ],
        'avatar'        => [
            'field'    => 'avatar',
            'db_field' => 'm.avatar',
            'label'    => 'Avatar',
            'rules'    => 'required',
            'form'     => [
                'type'   => 'file', //multiple_file
                'class'  => 'ace_file_input',//Use ACE theme for file input
//                'attr'         => 'data-disable_client_validate=1',//Disable validate in client
                'upload' => [//As config of File Upload Class in codeingiter
                    'upload_path'      => 'upload/demo/avatars',
                    'allowed_types'    => 'gif|jpg|png|jpeg',
                    'max_size'         => '2048',
//                    'min_size'         => '100',
                    'min_width'        => 300,
                    'min_height'       => 400,
//                    'max_width'        => 1200,
//                    'max_height'       => 1600,
                    'encrypt_name'     => TRUE,
                    'file_ext_tolower' => TRUE,
                ],
            ],
        ],
        'role_id'       => [
            'field'    => 'role_id',
            'db_field' => 'g.id',
            'label'    => 'Quyền',
            'rules'    => 'required',
            'form'     => [
                'type'            => 'select',
                'class'           => 'select2',
                'target_model'    => 'M_demo_role',
                'target_function' => 'dropdown',
                'target_arg'      => ['id', 'name'],
            ],
            'filter'   => [
                'type' => 'multiple_select',
            ],
        ],
        'role_name'     => [
            'field'    => 'role_name',
            'db_field' => 'g.name',
            'label'    => 'Quyền',
            'rules'    => 'required',
            'table'    => TRUE,
        ],
        'active'        => [
            'field'  => 'active',
            'label'  => 'Trạng thái',
            'rules'  => 'required',
            'form'   => [
                'type'            => 'select',
                'target_model'    => 'this',
                'target_function' => 'get_status',
                'class'           => 'inline_select',
            ],
            'filter' => [
                'type' => 'multiple_select',
            ],
            'table'  => [
                'callback_render_data' => "get_status_text",
                'class'                => "hidden-480 disable_sort",
            ],
        ],
        'password'      => [
            'field' => 'password',
            'label' => 'Mật khẩu',
            'rules' => 'required|min_length[6]',
            'form'  => [
                'type'                 => 'password',
                'callback_render_html' => 'custom_render_password',
            ],
        ],
        'password_conf' => [
            'field' => 'password_conf',
            'label' => 'Nhập lại mật khẩu',
            'rules' => 'required|matches[password]',
            'form'  => [
                'type' => 'password',
            ],
        ],
        'created_on'    => [
            'field' => 'created_on',
            'label' => 'Ngày tạo',
            'rules' => 'readonly',
            'table' => [
                'callback_render_data' => "timestamp_to_date",
                'class'                => "hidden-480",
                'attr'                 => 'data-check=\'true\'',
            ],
        ],
    ];


    public function __construct() {
        parent::__construct();
        $this->before_get[] = "join_role_table";
    }

    public function join_role_table() {
        $this->db->select($this->_table_alias . ".*, g.name as role_name, g.id as role_id");
        $this->db->join("ion_users_groups as ug", $this->_table_alias . ".id=ug.user_id");
        $this->db->join("ion_groups as g", "ug.group_id=g.id");
    }

    public function get_status() {
        return [
            '1' => 'Kich hoat',
            '0' => 'Khoa',
        ];
    }

    public function get_status_text($id) {
        $status = $this->get_status();
        if (isset($status[$id])) {
            return $status[$id];
        } else {
            return $id;
        }
    }

    public function insert($data, $skip_validation = FALSE) {
        if ($skip_validation === FALSE) {
            $data = $this->validate($data);
        }
        if ($data !== FALSE) {
            $data = $this->trigger('before_create', $data);
            $insert_id = $this->ion_auth->register($data['email'], $data['password'], $data['email'], $data, [$data['role_id']]);
            $this->trigger('after_create', $insert_id);
            return $insert_id;
        } else {
            return FALSE;
        }
    }

    public function update($id, $data, $skip_validation = FALSE) {
        $validate = $this->get_validate_from_schema();
        if ($data['password'] == "" && $data['password_conf'] == "") {
            unset($data['password']);
            unset($data['password_conf']);
            unset($validate['password']);
            unset($validate['password_conf']);
        }
        $validate = $this->get_validate_for_update($id, $validate);
        if ($skip_validation === FALSE) {
            $data = $this->validate($data, $validate);
        }
        $new_group = isset($data['role_id']) ? $data['role_id'] : NULL;
        unset($data['role_id']);
        unset($data['password_conf']);
        $update_result = parent::update($id, $data, TRUE);
        if ($new_group) {
            $this->update_group($id, $new_group);
        }
        if (isset($data['password'])) {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->ion_auth->reset_password($data[$identity_column], $data['password']);
        }
        return $update_result;

    }

    public function update_group($id, $new_group) {
        $old_group = $this->ion_auth->get_users_groups($id);
        $change = TRUE;
        foreach ($old_group->result() as $group_item) {
            if ($new_group == $group_item->id) {//Not change
                $change = FALSE;
                break;
            }
        }
        if ($change) {
            $this->ion_auth->remove_from_group(FALSE, $id);
            $this->ion_auth->add_to_group($new_group, $id);
        }
    }

    public function delete_many($primary_values) {
        $result = parent::delete_many($primary_values);
        foreach ($primary_values as $id) {
            $this->ion_auth->deactivate($id);
        }
        return $result;
    }
}
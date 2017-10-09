<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 14/06/16
 * Time: 16:49
 */
class Crud_manager extends Crud_model {

    public $schema = Array();

    public function __construct() {
        parent::__construct();
        $this->_standard_schema();
    }

    /**
     * Get validate rule for update
     *
     * @param      $edit_id
     * @param null $validate
     *
     * @return array
     */

    public function get_validate_for_update($edit_id, $validate = NULL) {
        if (!$validate) {
            $validate = $this->get_validate_from_schema();
        }
        $table_key = $this->get_primary_key();
        foreach ($validate as &$item) {
            $rules = $item['rules'];
            $pattern = [];
            $replacement = [];
            //Fix rule for is_unique (is_unique will ignore current row)
            array_push($pattern, '/is_unique\[([^]]+)\]/');
            array_push($replacement, "is_unique[$1,$table_key!=$edit_id]");

            //Fix rule for upload file: remove required because old value file is not same as input field
            array_push($pattern, '/file_required(.*)required/', '/required(.*)file_required/', '/file_required/');
            array_push($replacement, "$1", "$1", "");

            array_push($pattern, '/\|+/', '/^\|/', '/\|$/');
            array_push($replacement, "|", "", "");

            $item['rules'] = preg_replace($pattern, $replacement, $rules);
        }
        return $validate;
    }

    /**
     * Updated a record based on the primary value.
     */
    public function update($primary_value, $data, $skip_validation = FALSE) {
        if ($skip_validation === FALSE) {
            $validate = $this->get_validate_for_update($primary_value);
            $data = $this->validate($data, $validate);
        }
        return parent::update_many($primary_value, $data, TRUE);
    }

    /**
     * @param array      $data     Data need to validate
     * @param array|null $validate Rule validate, if NULL, get from schema
     *
     * @return bool|array Validate data with validate return FALSE if invalid, return data if valid
     */
    public function validate($data, $validate = NULL) {
        if (!$validate) {
            $validate = $this->get_validate_from_schema();
        }
        $result = parent::validate($data, $validate);
        if ($result) {
            $result = $this->file_validated_handle($validate, $result);
        }
        return $result;
    }

    protected function file_validated_handle($validate, $form_data) {
        foreach ($validate as $field => $item) {
            $form = $this->schema[$field]['form'];
            if (isset($form['type'])                                                //Has 'type' attribute in form
                && ($form['type'] == "file" || $form['type'] == "multiple_file")    //Type is 'file' or 'multiple_file'
            ) {
                if (isset($_FILES[$field])) { //Has new file upload: update data
                    $this->load->library('upload');
                    if (!isset($form['upload']) || !isset($form['upload']['upload_path'])) {
                        throw new Exception("Missing upload config for input form.");
                    }
                    if (!isset($form['upload']['upload_path'])) {
                        throw new Exception("Missing upload_path in config.");
                    }
                    $upload_config = $form['upload'];
                    $this->upload->initialize($upload_config);
                    $upload_result = $this->upload->do_upload($field);
                    if ($upload_result) {
                        $file_data = $this->upload->data();
                        $form_data[$field] = $form['upload']['upload_path'] . "/" . $file_data['file_name'];
                    } else {
                        $error = $this->upload->error_msg;
                        $this->form_validation->add_error($field, $error);
                        return FALSE;
                    }
                } else { //no have file upload: keep old value
                    unset($form_data[$field]);
                }

            }
        }
        return $form_data;
    }

    protected function _standard_schema() {
        foreach ($this->schema as &$item) {
            if (!isset($item['db_field'])) {
                $item['db_field'] = $this->_table_alias . "." . $item['field'];
            }
            if (isset($item['table']) && !is_array($item['table'])) {
                $item['table'] = Array();
            }
            if (isset($item['form']) && !is_array($item['form'])) {
                $item['form'] = Array();
            }
            if (isset($item['filter']) && !is_array($item['filter'])) {
                $item['filter'] = Array();
            }
            if (!isset($item['rules'])) {
                $item['rules'] = "";
            }
        }
    }

    /**
     * Get validate array of model from schema
     *
     * @return array
     */
    public function get_validate_from_schema() {
        $validate = Array();
        foreach ($this->schema as $item) {
            if (!isset($item['form'])) {
                continue;
            }
            $validate[$item['field']] = Array(
                'field'    => $item['field'],
                'db_field' => $item['db_field'],
                'label'    => $item['label'],
                'rules'    => $item['rules'],
                'errors'   => isset($item['errors']) ? $item['errors'] : [],
            );
            //Add validate with select and multiple select
            if (isset($item['form']['type']) &&
                ($item['form']['type'] == 'select' || $item['form']['type'] == 'multiple_select')
            ) {
                $validate[$item['field']] = $this->_get_validate_for_selected($item, $validate[$item['field']]);
            }
            //Add validate with file and multiple file
            if (isset($item['form']['type']) &&
                ($item['form']['type'] == 'file' || $item['form']['type'] == 'multiple_file')
            ) {
                $validate[$item['field']] = $this->_get_validate_for_file($item, $validate[$item['field']]);
            }
        }
        return $validate;
    }

    private function _get_validate_for_selected($schema_item, $validate_item) {
        $list_in = $this->get_data_select($schema_item['form']);
        $list_string = implode(",", array_keys($list_in));
        $this->_add_validate_rule($validate_item['rules'], "in_list[$list_string]");
        return $validate_item;
    }

    private function _add_validate_rule(&$org_rule, $add_string) {
        if (!strlen($add_string)) {
            return $org_rule;
        }
        if (is_string($org_rule)) {
            if (strlen($org_rule)) {
                $org_rule .= "|$add_string";
            } else {
                $org_rule .= "$add_string";
            }
        } else if (is_array($org_rule)) {
            $org_rule[] = $add_string;
        }
        return $org_rule;
    }

    private function _get_validate_for_file($schema_item, $validate_item) {
        if (!isset($schema_item['form']['upload'])) {
            return $validate_item;
        }
        if (strpos($validate_item['rules'], "required") !== FALSE) {
            $this->_add_validate_rule($validate_item['rules'], "file_required");
        }
        $upload_config = $schema_item['form']['upload'];
        $file_rules = ['upload_path', 'allowed_types', 'min_size', 'max_size',
            'min_width', 'max_width', 'min_height', 'max_height'];
        foreach ($file_rules as $item) {
            if (isset($upload_config[$item])) {
                $value = str_replace("|", ",", $upload_config[$item]);
                $more_rule = "file_{$item}[$value]";
                $this->_add_validate_rule($validate_item['rules'], $more_rule);
            }
        }
        return $validate_item;
    }

    /**
     * Get array to show add/edit form
     *
     * @return array
     */
    public function get_form() {
        $form = Array();
        foreach ($this->schema as $item) {
            if (!isset($item['form'])) {
                continue;
            }
            if (!is_array($item['form'])) {
                $item['form'] = Array();
            }
            $form_item = Array(
                'field'    => $item['field'],
                'db_field' => $item['db_field'],
                'label'    => isset($item['form']['label']) ? $item['form']['label'] : $item['label'],
                'rules'    => $item['rules'],
                'form'     => $item['form'],
            );
            if (isset($form_item['form']['type']) &&
                ($form_item['form']['type'] == 'select' || $form_item['form']['type'] == 'multiple_select')
            ) {
                $form_item['form']['data_select'] = $this->get_data_select($form_item['form']);
            }
            $form[$item['field']] = $form_item;
        }
        return $form;
    }

    /**
     * Get filter array of model from schema
     */
    public function get_filter() {
        $filter = Array();
        foreach ($this->schema as $item) {
            if (!isset($item['filter'])) {
                continue;
            }
            if (!is_array($item['filter'])) {
                $item['filter'] = Array();
            }
            $temp_filter = Array(
                'field'    => $item['field'],
                'db_field' => $item['db_field'],
                'label'    => isset($item['filter']['label']) ? $item['filter']['label'] : $item['label'],
                'rules'    => $item['rules'],
                'filter'   => $item['filter'],
            );
            if (isset($item['form'])) {
                $temp_filter['filter'] = array_merge($item['form'], $item['filter']);
            }
            if (isset($temp_filter['filter']) && isset($temp_filter['filter']['type']) &&
                ($temp_filter['filter']['type'] == 'select' || $temp_filter['filter']['type'] == 'multiple_select')
            ) {
                $temp_filter['filter']['data_select'] = $this->get_data_select($temp_filter['filter']);
            }
            $filter[$item['field']] = $temp_filter;
        }
        return $filter;
    }

    /**
     * @return array Field of manager table
     */
    public function get_table_field() {
        $table_field = Array();
        foreach ($this->schema as $item) {
            if (isset($item['table'])) {
                $temp_column = Array(
                    'field'    => $item['field'],
                    'db_field' => $item['db_field'],
                    'label'    => isset($item['table']['label']) ? $item['table']['label'] : $item['label'],
                    'rules'    => $item['rules'],
                    'table'    => $item['table'],
                );
                $table_field[$item['field']] = $temp_column;
            }
        }
        return $table_field;
    }

    /**
     * get filter data from filter form
     *
     * @param $post_filter
     *
     * @return array
     */
    public function standard_filter_data($post_filter) {
        $where_condition = Array();
        $where_in_condition = Array();
        $like_condition = Array();
        $schema_filters = $this->get_filter();
        foreach ($post_filter as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
            }
            if (isset($schema_filters[$key])) {
                $db_key = $schema_filters[$key]['db_field'];
                $filter = $schema_filters[$key]['filter'];
                if (isset($filter['search_type'])) {
                    switch ($filter['search_type']) {
                        case 'where' :
                            is_string($value) AND strlen($value) AND $where_condition[$db_key] = $value;
                            break;
                        case 'where_in' :
                            is_string($value) AND strlen($value) AND $where_in_condition[$db_key] = $value;
                            is_array($value) AND count($value) AND $where_in_condition[$db_key] = $value;
                            break;
                        case 'like' :
                            is_string($value) AND strlen($value) AND $like_condition[$db_key] = $value;
                            break;
                        default :
                            is_string($value) AND strlen($value) AND $like_condition[$db_key] = $value;
                    }
                } elseif (isset($filter['type'])) {
                    switch ($filter['type']) {
                        case 'select' :
                            is_string($value) AND strlen($value) AND $where_condition[$db_key] = $value;
                            break;
                        case 'multiple_select' :
                            is_string($value) AND strlen($value) AND $where_in_condition[$db_key] = $value;
                            is_array($value) AND count($value) AND $where_in_condition[$db_key] = $value;
                            break;
                        default :
                            is_string($value) AND strlen($value) AND $like_condition[$db_key] = $value;
                    }
                } else {
                    $value AND $like_condition[$db_key] = $value;
                }
            } else {
                continue;
            }
        }
        return [
            "where"    => $where_condition,
            "where_in" => $where_in_condition,
            "like"     => $like_condition,
        ];
    }

    /**
     * Get data for select
     *
     * @param $form
     *
     * @return mixed
     * @throws Exception
     */
    public function get_data_select($form) {
        if (!isset($form['target_model']) ||
            !isset($form['target_function'])
        ) {
            throw new Exception("Filter type 'select' must be have 'target_model' and 'target_function'");
        }
        $target_model = $form['target_model'];
        $target_function = $form['target_function'];
        $target_arg = Array();
        if (isset($form['target_arg'])) {
            $target_arg = $form['target_arg'];
        }
        if ($target_model == 'this') {
            $data_select = call_user_func_array(Array($this, $target_function), $target_arg);
        } else {
            $model_name = strtolower('select_' . $target_model);
            if (!isset($this->$model_name)) {
                $this->load->model($target_model, $model_name);
            }
            $data_select = call_user_func_array(Array($this->$model_name, $target_function), $target_arg);
        }
        return $data_select;
    }

    /**
     * Get list object with special condition
     *
     * @param   array  $whereCondition   Array with key is field need to find, and value is String, which need to find
     *                                   with WHERE
     *
     * @param   array  $whereInCondition Array with key is field need to find, and value is Array of value need to find
     *                                   with WHERE_IN
     * @param   array  $likeCondition    Array with key is field need to find, and value is String of value need to find
     *                                   with LIKE
     * @param   Int    $limit            Limit number of item to get (same as LIMIT in SQL)
     * @param   Int    $post             Item start to get (same as POST in SQL)
     * @param   String $order            Order value, a String as 'title DESC, name ASC'
     *
     * @return array                    A Array of object with attribute base on $schema
     */
    public function get_list_filter($whereCondition, $whereInCondition, $likeCondition, $limit = 0, $post = 0, $order = NULL) {
        $this->_filter_prepare($whereCondition, $whereInCondition, $likeCondition, $limit, $post, $order);
        return $this->get_all();
    }

    /**
     * Get total item with special condition(use with get_list_filter for paging)
     *
     * @param   array $whereCondition   Array with key is field need to find, and value is String, which need to find
     *                                  with WHERE
     * @param   array $whereInCondition Array with key is field need to find, and value is Array of value need to find
     *                                  with WHERE_IN
     * @param   array $likeCondition    Array with key is field need to find, and value is String of value need to find
     *                                  with LIKE
     *
     * @return  Int     Count of all item match param condition
     */
    public function get_list_filter_count($whereCondition, $whereInCondition, $likeCondition) {
        $this->_filter_prepare($whereCondition, $whereInCondition, $likeCondition, 0, 0, NULL);
        return $this->count_all_results();
    }

    protected function _filter_prepare($whereCondition, $whereInCondition, $likeCondition, $limit = 0, $post = 0, $order = NULL) {
        if (is_array($whereCondition) && count($whereCondition) > 0) {
            $this->_database->where($whereCondition);
        } else if (intval($whereCondition) > 0) {
            $this->_database->where("m." . $this->primary_key, $whereCondition);
        }
        if (is_array($whereInCondition) && count($whereInCondition) > 0) {
            foreach ($whereInCondition as $key => $value) {
                if ((is_array($value) && count($value)) ||
                    (is_string($value) && strlen($value))
                ) {
                    $this->_database->where_in($key, $value);
                }
            }
        }
        if (is_array($likeCondition) && count($likeCondition) > 0) {
            foreach ($likeCondition as $key => $value) {
                $this->_database->like($key, $value);
            }
        }
        if ($limit) {
            $this->limit($limit, $post);
        }
        if ($order) {
            $this->order_by($order);
        } else {
            $this->order_by($this->_table_alias . "." . $this->primary_key, "DESC");
        }
    }

    public function get_primary_key() {
        return $this->primary_key;
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
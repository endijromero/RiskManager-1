<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Manager_base
 *
 * Abstract class using for manager a table
 *
 * @package manager_base
 * @author  Pham Trong <phamtrong204@gmail.com>
 * @version 0.0.0
 */
abstract class Manager_base extends Admin_layout {

    /**
     * Array of config data, using for manager function (add/edit/delete/manager...)
     * This value will be set in constructor, <b>after call abstract method 'setting_class'</b>
     * Struct
     * <pre>
     * Array (
     *      "view"      => "", <i>String: Url <b>View detail</b> a record of model</i>
     *      "add"       => "", <i>String: Url <b>Add</b> a record of model</i>
     *      "edit"      => "", <i>String: Url <b>Edit</b> a record of model</i>
     *      "delete"    => "", <i>String: Url <b>Delete</b> a record of model</i>
     *      "manager"   => "", <i>String: Url <b>Manager table</b> of model</i>
     * )
     * </pre>
     *
     * @var array
     */
    public $url = Array(
        "view"    => "",
        "add"     => "",
        "edit"    => "",
        "delete"  => "",
        "manager" => "",
        "search"  => "",
    );

    /**
     * Config name of object, which is managed by class, which extend this class
     * <b>this variable will be declare in abstract method(which extend this class)</b>
     * Struct:
     * <pre>
     * Array (
     *      "class"  => "", <i>String: class name
     *      "view"   => "", <i>String: view folder
     *      "model"  => "", <i>String: model name
     *      "object" => "", <i>String: object name
     * )
     * </pre>
     *
     * @var array
     */
    public $name = Array(
        "class"  => "",
        "view"   => "",
        "model"  => "",
        "object" => "",
    );

    /**
     * @var int Number of button show on pagination
     */
    public $paging_item_display = 7;
    /**
     * @var int Number of record per page
     */
    public $item_per_page = 20;
    /**
     * @var string prefix of view folder
     */
    public $path_theme_view = "admin/";

    public function __construct() {
        parent::__construct();
        $this->setting_class();
        $this->load->model($this->name["model"], "model");
        $this->url["add"] = site_url($this->name["class"] . "/add");
        $this->url["view"] = $this->name["class"] . "/view/";
        $this->url["edit"] = $this->name["class"] . "/edit/";
        $this->url["delete"] = $this->name["class"] . "/delete/";
        $this->url["manager"] = site_url($this->name["class"] . "/manager");
    }

    /**
     * Index function, pass all to 'manager' function
     */
    public function index() {
        $this->manager();
    }

    /**
     * Abstract function using setting $this->name variable (view demo controller for detail)
     */
    abstract function setting_class();

    /**
     * Show form for <b>adding</b> a record
     *
     * @param array $data More data pass to view, using on override or call from other function
     *
     * @return string return view and state to clien (json if request is ajax call, html instead of)
     */
    public function add($data = Array(), $data_return = Array()) {
        if (!isset($data["save_link"])) {
            $data["save_link"] = site_url($this->name["class"] . "/add_save");
        }
        $form_html = $this->get_form_html($data);
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "get_form_add_response";
        }
        if ($this->input->is_ajax_request()) {
            $data_return["state"] = 1;
            $data_return["html"] = $form_html;
            echo json_encode($data_return);
            return TRUE;
        } else {
            $this->set_data_part("title", "Thêm  " . $this->name["object"], FALSE);
            $this->show_page($form_html);
        }
    }

    /**
     * Handle data for adding record
     *
     * @param array   $data          More data pass to <b>view</b>, using on override or call from other function
     * @param array   $data_return   More data pass to <b>client</b>, using on override or call from other function
     * @param boolean $skip_validate TRUE if skip validate, default FALSE
     *
     * @return string return view and state to client (json if request is ajax call, html instead of)
     */
    public function add_save($data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "save_form_add_response";
        }
        if (sizeof($data) == 0) {
            $data = $this->input->post();
        }
        $insert_id = $this->model->insert($data, $skip_validate);
        $key_field = $this->model->get_primary_key();
        $data_validated[$key_field] = $insert_id;
        if ($insert_id) {
            $data_return["key_name"] = $key_field;
            $data_return["record"] = $data_validated;
            $data_return["state"] = 1; /* state = 1 : insert success*/
            $data_return["msg"] = "Thêm bản ghi thành công";
//            $data_return["redirect"] = $this->url["manager"];
            echo json_encode($data_return);
            return $insert_id;
        } else {
            $data_return["state"] = 0; /* state = 2 : server error */
            if ($insert_id === FALSE) {
                $data_return["msg"] = "Dữ liệu gửi lên không hợp lệ!";
            } else {
                $data_return["msg"] = "Thêm bản ghi thất bại do lỗi server, vui lòng thử lại hoặc liên hệ quản lý hệ thống!";
            }
            $data_return["data"] = $data;
            $data_return["error"] = $this->model->get_validate_error();
            echo json_encode($data_return);
            return FALSE;
        }
    }

    /**
     * Get form for <b>editing</b> a record
     *
     * @param int   $id   id of record need to be edited
     * @param array $data More data pass to <b>view</b>, using on override or call from other function
     *
     * @return string return view and state to client (json if request is ajax call, html instead of)
     */
    public function edit($id = 0, $data = Array(), $data_return = Array()) {
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "get_form_edit_response";
        }
        if (!$id) {
            $data_return["state"] = 0;
            $data_return["msg"] = "Id không tồn tại";
            echo json_encode($data_return);
            return FALSE;
        }
        if (!isset($data["save_link"])) {
            $data["save_link"] = site_url($this->name["class"] . "/edit_save/" . $id);
        }
        $data_return["record_data"] = $this->model->get($id);
        $form_html = $this->get_form_html($data, $data_return["record_data"]);
//        $data_return["form"] = $this->model->get_form();
        if ($this->input->is_ajax_request()) {
            $data_return["state"] = 1;
            $data_return["html"] = $form_html;
            echo json_encode($data_return);
            return TRUE;
        } else {
            $this->set_data_part("title", "Sửa " . $this->name["object"], FALSE);
            $this->show_page($form_html);
        }
    }

    /**
     * Handle data for editing record
     *
     * @param int     $id            id of record need to be edited
     * @param Array   $data          More data pass to <b>view</b>, using on override or call from other function
     * @param Array   $data_return   More data pass to <b>client</b>, using on override or call from other function
     * @param boolean $skip_validate TRUE if skip validate, default FALSE
     *
     * @return json trả dữ liệu về phía client JSON
     */
    public function edit_save($id = 0, $data = Array(), $data_return = Array(), $skip_validate = FALSE) {
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "save_form_edit_response";
        }
        if (sizeof($data) == 0) {
            $data = $this->input->post();
        }
        $id = intval($id);
        if (!$id) {
            $data_return["state"] = 0; /* state = 0 : invalid id */
            $data_return["msg"] = "Bản ghi không tồn tại";
            echo json_encode($data_return);
            return FALSE;
        }
        $update = $this->model->update($id, $data, $skip_validate);
        if ($update) {
            $data_return["key_name"] = $this->model->get_primary_key();
            $data_return["record"] = $this->standard_record_data($this->model->get($id));
            $data_return["state"] = 1; /* state = 1 : insert success */
            $data_return["msg"] = "Sửa bản ghi thành công.";
//            $data_return["redirect"] = $this->url["manager"];
            echo json_encode($data_return);
            return TRUE;
        } else {
            $data_return["data"] = $data;
            $data_return["state"] = 0; /* state = 0 : invalid data */
            if ($update === FALSE) {
                $data_return["msg"] = "Dữ liệu gửi lên không hợp lệ";
            } elseif ($update === 0) {
                $data_return["msg"] = "Bạn chưa thay đổi dữ liệu!";
            }
            $data_return["error"] = $this->model->get_validate_error();
            echo json_encode($data_return);
            return FALSE;
        }
    }

    /**
     * Remove record, param can be pass one id with uri or 'list_id' with post data
     *
     * @param int   $id          ID of record need to delete
     * @param array $data        Param pass to view(using when overrider or call from other function)
     * @param array $data_return More data pass to <b>client</b>, using on override or call from other function
     *
     * @return boolean|string json string, contain id deleted and status
     */
    public function delete($id = 0, $data = Array(), $data_return = Array()) {
        $id = intval($id);
        if (!isset($data_return["callback"])) {
            $data_return["callback"] = "delete_respone";
        }
        if ($this->input->post() || $id > 0) {
            if (isset($data["list_id"]) && sizeof($data["list_id"])) {
                $list_id = $data["list_id"];
            } else {
                if ($this->input->post() && $id == "0") {
                    $list_id = $this->input->post("list_id");
                } elseif ($id > 0) {
                    $list_id = Array($id);
                }
            }
            $affected_row = $this->model->delete_many($list_id);
            if ($affected_row) {
                $data_return["list_id"] = $list_id;
                $data_return["state"] = 1;
                $data_return["msg"] = "Xóa bản ghi thành công";
            } else {
                $data_return["list_id"] = $list_id;
                $data_return["state"] = 0;
                $data_return["msg"] = "Bản ghi đã được xóa từ trước hoặc không thể bị xóa. Vui lòng tải lại trang!";
            }
            echo json_encode($data_return);
            return TRUE;
        } else {
            $data_return["state"] = 0;
            $data_return["msg"] = "Id không tồn tại";
            echo json_encode($data_return);
            return FALSE;
        }
    }

    /**
     * Get html for <b>viewing</b> a record
     *
     * @param int   $id          ID if record need to be viewed
     * @param array $data        More data pass to <b>view</b>, using on override or call from other function
     * @param array $data_return More data pass to <b>client</b>, using on override or call from other function
     *
     * @return boolean|string json string, contain html and data of record
     */
    public function view($id = 0, $data = Array(), $data_return = Array()) {
        //TODO: in developing
    }


    /**
     * Show manager table of manager object
     *
     * @param array $data More data pass to <b>view</b>, using on override or call from other function
     */
    public function manager($data = Array()) {
        $default_data = Array();
        $default_data["add_link"] = $this->url["add"];
        $default_data["delete_list_link"] = site_url($this->url["delete"]);
        $default_data["ajax_data_link"] = site_url($this->name["class"] . "/ajax_list_data");
        $default_data["title"] = "Quản Lý " . $this->name["object"];
        $default_data["view_file"] = $this->path_theme_view . "base_manager/manager_container";
        $data = array_merge($default_data, $data);
        $view_file = $data["view_file"];
        unset($data["view_file"]);
        $data['filter_html'] = $this->get_filter_html($data);
        $data['table_header'] = $this->get_table_header($data);
        $content = $this->load->view($view_file, $data, TRUE);
        $this->set_html_part('title', "Quản lý " . $this->name["object"]);
        $this->show_page($content);
    }

    /**
     * Get data for manager
     * Post param:
     *      - filter     => array data of filter
     *      - limit      => Limit of record
     *      - order      => array of order
     *      - page       => page need to get
     *
     * @param Array More data pass to <b>view</b>, using on override or call from other function
     *
     * @return string json string, contain html and data of record
     */
    public function ajax_list_data($data = Array()) {
        $condition = $this->get_filter_raw_condition();
        $data_paging = $this->get_paging_data($condition);
        $data_order = $this->get_order_data($condition);
        $data = array_merge($data, $data_paging, $data_order);
        $filter = isset($condition["filter"]) ? $condition["filter"] : [];
        $query_cond = $this->model->standard_filter_data($filter);
        $record = $this->model->get_list_filter(
            $query_cond['where'], $query_cond['where_in'], $query_cond['like'],
            $data['limit'], $data['post'], $data['order_db']
        );
        $data['sql'] = $this->db->last_query();
        $data['columns'] = $this->get_column_data();
        $data['record'] = $this->standard_record_data($record, $data['columns']);
        $data["key_name"] = $this->model->get_primary_key();
        $data["filter"] = $filter;

        if (isset($data['view_file'])) {
            $view_file = $data['view_file'];
        } else {
            $view_file = $this->path_theme_view . "base_manager/table_data";
        }

        $content = $this->load->view($view_file, $data, TRUE);
        if ($this->input->is_ajax_request()) {
            if (isset($data['callback'])) {
                $data_return["callback"] = $data['callback'];
            } else {
                $data_return["callback"] = "get_manager_data_response";
            }
            $data_return["state"] = 1;
//            $data_return["data"] = $data;
            $data_return["html"] = $content;
            echo json_encode($data_return);
            return TRUE;
        } else {
            $this->show_page($content);
        }
    }

    protected function get_filter_raw_condition() {
        return $this->input->post();
    }

    protected function standard_record_data($records, $columns = NULL) {
        if (!$columns) {
            $columns = $this->get_column_data();
        }
        if (is_array($records)) {
            foreach ($records as &$record) {
                $record = $this->standard_record_data($record, $columns);
            }
        } else {
            foreach ($columns as $column_name => $column_data) {
                $origin_column_value = isset($records->$column_name) ? $records->$column_name : NULL;
                if (isset($column_data['table']['callback_render_data'])) {
                    $callback_render_data = $column_data['table']['callback_render_data'];
                    if (is_array($callback_render_data)) {
                        foreach ($callback_render_data as $callback) {
                            if (method_exists($this, $callback)) {
                                $call_scope = $this;
                            } elseif (method_exists($this->model, $callback)) {
                                $call_scope = $this->model;
                            } else {
                                throw new Exception("['table']['callback_render_data'] of '$column_name'(function '$callback') 
                                does not exist at both controller ({$this->name['class']}) and model ({$this->name['model']})!");
                            }
                            $records->$column_name = call_user_func_array(
                                Array($call_scope, $callback),
                                Array($origin_column_value, $column_name, &$records, $column_data, $this)
                            );
                        }
                    } else if (is_string($callback_render_data)) {
                        if (method_exists($this, $callback_render_data)) {
                            $call_scope = $this;
                        } elseif (method_exists($this->model, $callback_render_data)) {
                            $call_scope = $this->model;
                        } else {
                            throw new Exception("['table']['callback_render_data'] of '$column_name'(function '$callback_render_data') 
                            does not exist at both controller ({$this->name['class']}) and model ({$this->name['model']})!");
                        }
                        $records->$column_name = call_user_func_array(
                            Array($call_scope, $callback_render_data),
                            Array($origin_column_value, $column_name, &$records, $column_data, $this)
                        );
                    } else {
                        throw new Exception("['table']['callback_render_data'] of $column_name must be 'string' or 'array'!");
                    }
                }
            }
        }
        return $records;
    }

    protected function get_paging_data($condition) {
        $data = Array();
        $limit = intval(isset($condition["limit"]) ? $condition["limit"] : $this->item_per_page);
        $filter = isset($condition["filter"]) ? $condition["filter"] : [];
        $current_page = intval(isset($condition["page"]) ? $condition["page"] : 1);
        if ($limit < 0) {
            $limit = 0;
        }
        /* If change limit or change filter: reset page to 1 */
        $old_condition = $this->session->userdata('table_manager_condition');
        $old_limit = intval(isset($old_condition["limit"]) ? $old_condition["limit"] : $this->item_per_page);
        $old_filter = isset($old_condition["filter"]) ? $old_condition["filter"] : [];
        ksort($filter);
        ksort($old_filter);
        if (($limit != $old_limit) || (json_encode($filter) != json_encode($old_filter))) {
            $current_page = 1;
        }
        //Update session condition after reset page
        $this->session->set_userdata('table_manager_condition', $condition);
        $post = ($current_page - 1) * $limit;
        if ($post < 0) {
            $post = 0;
            $current_page = 1;
        }
        $query_cond = $this->model->standard_filter_data($filter);
        $total_item = $this->model->get_list_filter_count($query_cond['where'], $query_cond['where_in'], $query_cond['like']);
        if ($limit != 0) {
            $total_page = (int)($total_item / $limit);
        } else {
            $total_page = 0;
        }
        if (($total_page * $limit) < $total_item) {
            $total_page += 1;
        }
        $link = "#";
        $data["paging"] = $this->_get_paging($total_page, $current_page, $this->paging_item_display, $link);
        $data["from"] = $post + 1;
        $data["to"] = $post + $limit;
        if ($data["to"] > $total_item || $limit == 0) {
            $data["to"] = $total_item;
        }
        $data["limit"] = $limit;
        $data["post"] = $post;
        $data["total"] = $total_item;
        return $data;
    }

    /**
     * Standard order data
     *
     * @param $condition
     *
     * @return mixed
     */
    protected function get_order_data($condition) {
        $order = isset($condition["order"]) ? $condition["order"] : NULL;
        $order_db = Array();
        $order_view = Array();
        $temp = explode(",", $order);
        for ($i = 0; $i < sizeof($temp); $i++) {
            $temp[$i] = trim($temp[$i]);
            $order_piece = explode(" ", $temp[$i]);
            /* Get item is in schema and value is 'asc' or 'desc' only */
            if (sizeof($order_piece) == 2 &&
                array_key_exists($order_piece[0], $this->model->schema) &&
                ($order_piece[1] == "asc" || $order_piece[1] == "desc")
            ) {
                $order_key = $order_piece[0];
                $db_key = $this->model->schema[$order_key]['db_field'];
                $order_db[$db_key] = $order_piece[1];
                $order_view[$order_key] = $order_piece[1];
            } else {
                unset($temp[$i]);
            }
        }
        $data["order_db"] = $order_db;
        $data["order_view"] = $order_view;
        return $data;
    }

    protected function get_filter_html($data = Array()) {
        $data['form_id'] = uniqid();
        $data['filter'] = $this->model->get_filter();
        foreach ($data['filter'] as $key => &$item) {
            $item['html'] = $this->render_filter_item($item, $data['form_id']);
        }
        if (isset($data['view_file'])) {
            $view_file = $data['view_file'];
        } else {
            $view_file = $this->path_theme_view . "/base_manager/table_filter";
        }
        $filter_html = $this->load->view($view_file, $data, TRUE);
        return $filter_html;
    }

    protected function render_filter_item($form_item, $form_id) {
        $data = [
            'form_item' => $form_item,
            'form_id'   => $form_id,
        ];
        if (isset($form_item['filter']['callback_render_html'])) {
            $callback = $form_item['filter']['callback_render_html'];
            if (is_string($callback)) {
                if (method_exists($this, $callback)) {
                    $call_scope = $this;
                } elseif (method_exists($this->model, $callback)) {
                    $call_scope = $this->model;
                } else {
                    throw new Exception("['filter']['callback_render_html'] of field '$form_item[field]'(function '$callback') 
                    does not exist at both controller ({$this->name['class']}) and model ({$this->name['model']})!");
                }
                $more_arg = empty($form_item['form']['callback_render_html_args']) ? [] : $form_item['form']['callback_render_html_args'];
                $more_arg = is_array($more_arg) ? $more_arg : [$more_arg];
                array_unshift($more_arg, $form_item, $form_id, $this);
                return call_user_func_array(
                    Array($call_scope, $callback),
                    $more_arg
                );
            } else {
                throw new Exception("['filter']['callback_render_html'] of $form_item[field] must be 'string'!");
            }
        }
        return $this->load->view($this->path_theme_view . "/base_manager/table_filter_item", $data, TRUE);
    }

    protected function get_form_html($data = Array(), $record = NULL) {
        $data['form_id'] = uniqid();
        $data['form_title'] = "Thêm " . $this->name['object'];
        $data['form'] = $this->model->get_form();
        $data['is_edit'] = ($record === NULL) ? "0" : "1";
        foreach ($data['form'] as $key => &$item) {
            $value = NULL;
            if (isset($record->$key)) {
                $value = $record->$key;
            }
            $item['html'] = $this->render_form_item($item, $data['form_id'], $value);
        }
        if (isset($data['view_file'])) {
            $view_file = $data['view_file'];
        } else {
            $view_file = $this->path_theme_view . "/base_manager/form";
        }
        $form_html = $this->load->view($view_file, $data, TRUE);
        return $form_html;
    }

    protected function render_form_item($form_item, $form_id, $value = NULL) {
        $data = [
            'form_item' => $form_item,
            'form_id'   => $form_id,
            'value'     => $value,
        ];
        if (isset($form_item['form']['callback_render_html'])) {
            $callback = $form_item['form']['callback_render_html'];
            if (is_string($callback)) {
                if (method_exists($this, $callback)) {
                    $call_scope = $this;
                } elseif (method_exists($this->model, $callback)) {
                    $call_scope = $this->model;
                } else {
                    throw new Exception("['form']['callback_render_html'] of '$form_item[field]'(function '$callback') 
                    does not exist at both controller ({$this->name['class']}) and model ({$this->name['model']})!");
                }
                $more_arg = empty($form_item['form']['callback_render_html_args']) ? [] : $form_item['form']['callback_render_html_args'];
                $more_arg = is_array($more_arg) ? $more_arg : [$more_arg];
                array_unshift($more_arg, $form_item, $form_id, $value, $this);
                return call_user_func_array(
                    Array($call_scope, $callback),
                    $more_arg
                );
            } else {
                throw new Exception("['form']['callback_render_html'] of $form_item[field] must be 'string'!");
            }
        }
        return $this->load->view($this->path_theme_view . "/base_manager/form_item", $data, TRUE);
    }

    protected function get_table_header($data = Array()) {
        if (!isset($data["delete_list_link"])) {
            $data["delete_list_link"] = site_url($this->url["delete"]);
        }
        $filter_html = $this->load->view($this->path_theme_view . 'base_manager/table_header', $data, TRUE);
        return $filter_html;
    }

    /**
     * Add column to manager table
     * default this function will add 2 column (check at head and action button at last)
     *
     * @param array $columns Array of column
     *
     * @return array array of list column
     */
    protected function get_column_data($columns = Array()) {
        /* add check column */
        $columns["custom_check"] = Array(
            'label' => "<input type='checkbox' class='e_check_all' />",
            'table' => Array(
                'callback_render_data' => 'add_check_box',
                'class'                => '"min-width center disable_sort"',
            ),
        );
        $schema_column = $this->model->get_table_field();
        $columns = array_merge($columns, $schema_column);
        /* Add action column*/
        $columns["custom_action"] = Array(
            'label' => "Action",
            'table' => Array(
                'callback_render_data' => 'add_action_button',
                'class'                => '"no-wrap center disable_sort"',
            ),
        );
        return $columns;
    }

    /**
     * Get html for pagination
     *
     * @param int    $total   = total page
     * @param int    $current = current page
     * @param int    $display = page show on link
     * @param string $link    = origin link
     * @param string $key     = page key in get
     *
     * @return string html of pagination
     */
    protected function _get_paging($total, $current, $display, $link, $key = "p") {
        $data["total_page"] = $total;
        $data["current_page"] = $current;
        $data["page_link_display"] = $display;
        $data["link"] = $link;
        $data["key"] = $key;
        return $this->load->view($this->path_theme_view . "base_manager/paging", $data, TRUE);
    }

    protected function add_check_box($origin_column_value, $column_name, &$record, $column_data, $caller) {
        $primary_key = $this->model->get_primary_key();
        return "<input type='checkbox' name='_e_check_all' data-id='" . $record->$primary_key . "' />";
    }

    protected function add_action_button($origin_column_value, $column_name, &$record, $column_data, $caller) {
        $primary_key = $this->model->get_primary_key();
        $custom_action = "<div class='action-buttons'>";
//        $custom_action .= "<a class='e_ajax_link blue' href='" . site_url($this->url["view"] . $record->$primary_key) . "'><i class='ace-icon fa fa-search-plus bigger-130'></i></a>";
        if ((!isset($record->disable_edit) || !$record->disable_edit)) {
            $custom_action .= "<a class='e_ajax_link green' href='" . site_url($this->url["edit"] . $record->$primary_key) . "'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
            $custom_action .= "<a class='e_ajax_link e_ajax_confirm red' href='" . site_url($this->url["delete"] . $record->$primary_key) . "'><i class='ace-icon fa fa-trash-o  bigger-130'></i></a>";
        }
        $custom_action .= "</div>";
        return $custom_action;
    }

    protected function timestamp_to_date($origin_column_value) {
        if (intval($origin_column_value)) {
            return date('Y-m-d H:i:s', $origin_column_value);
        } else {
            return $origin_column_value;
        }
    }

    protected function is_in_group($group_name) {
        return $this->model->is_in_group($group_name);
    }
}

/* End of file manager_base.php */
/* Location: ./application/base/manager_base.php */
<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 3/17/16
 * Time: 13:01
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Demo
 */
class Demo extends Admin_layout {

    function __construct() {
        parent::__construct();
    }

    /**
     * Requests are not made to methods directly, the request will be for
     * an "object". This simply maps the object and method to the correct
     * Controller method.
     *
     * @access public
     * @param  string $object_called
     * @param  array $arguments The arguments passed to the controller method.
     */
    public function _remap($object_called, $arguments) {
        array_unshift($arguments, $object_called);
        $view = APPPATH . "views/admin/demo/$object_called.php";
        if (!file_exists($view)) {
            exit("Demo '$object_called' not found!!");
        }
        call_user_func_array([$this, "show_demo"], $arguments);
    }

    public function show_demo($page) {
        $page_header = "admin/demo/$page-header";
        if (file_exists(APPPATH . "views/$page_header.php")) {
            $more_head = $this->load->view($page_header, NULL, TRUE);
            $this->append_part("assets_header", $more_head);
        }
        $data = Array();
        $content = $this->load->view("admin/demo/$page", $data, TRUE);
        $this->show_page($content);
    }

}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 3/17/16
 * Time: 11:16
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

abstract class Admin_login_layout extends Base_layout {

    function __construct() {
        parent::__construct();
        $this->set_data_part("side_bar_left", "", FALSE);
        $this->set_data_part("footer", "", FALSE);
        $this->set_data_part("top_bar", "", FALSE);
        $this->set_layout_body("admin/base_layout/login/layout_body");
        $this->set_layout_all("admin/base_layout/login/layout_all");
    }

    private function _set_login_footer() {
        $data = Array(
            'view_file' => "admin/base_layout/login/footer",
        );
        $this->set_data_part('footer', $data);
    }

}

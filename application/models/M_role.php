<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 14/06/16
 * Time: 15:33
 */
class M_role extends Crud_manager {

    protected $_table = 'ion_groups';

    public function __construct() {
        parent::__construct();
//        $this->before_dropdown[] = "get_group_by_role";
    }

//    public function get_group_by_role() {
//        if ($this->is_in_group('admin')) {
//            $this->db->where_in('m.name', ['admin', 'corporation']);
//        } else {
//            $this->db->where_not_in('m.name', ['admin', 'corporation']);
//        }
//    }
}
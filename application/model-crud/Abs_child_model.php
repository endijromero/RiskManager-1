<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/21/2017
 * Time: 8:42 PM
 */
class Abs_child_model extends Crud_manager {
    protected $_parent_value = 0;
    protected $_parent_field = 'project_id';

    public function standard_filter_data($post_filter) {
        if ($this->_parent_field) {
            $post_filter[$this->_parent_field] = $this->_parent_value;
        }
        return parent::standard_filter_data($post_filter);
    }

    public function set_parent($parent_value) {
        $this->_parent_value = $parent_value;
    }
}
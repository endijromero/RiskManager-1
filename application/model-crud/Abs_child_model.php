<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/21/2017
 * Time: 8:42 PM
 */
class Abs_child_model extends Crud_manager {
    protected $_project_id = 0;

    public function standard_filter_data($post_filter) {
        if ($this->_project_id) {
            $post_filter['project_id'] = $this->_project_id;
        }
        return parent::standard_filter_data($post_filter);
    }

    public function set_project_id($project_id) {
        $this->_project_id = $project_id;
    }
}
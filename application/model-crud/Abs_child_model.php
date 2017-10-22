<?php

/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/21/2017
 * Time: 8:42 PM
 */
class Abs_child_model extends Crud_manager {
    protected $_parent_value = 0;
    protected $_parent_field = '';

    public function standard_filter_data($post_filter) {
        if ($this->_parent_field && $this->_parent_value) {
            $post_filter[$this->_parent_field] = $this->_parent_value;
        }
        return parent::standard_filter_data($post_filter);
    }

    public function set_parent($parent_value) {
        $this->_parent_value = $parent_value;
        if(isset($this->schema[$this->_parent_field]['filter'])){
            if(!isset($this->schema[$this->_parent_field]['filter']['search_type'])){
                $this->schema[$this->_parent_field]['filter']['search_type']='where';
            }
        }else{
            $this->schema[$this->_parent_field]['filter'] = ['search_type'=>'where'];
        }
    }

    public function remove_parent() {
        $this->_parent_value = 0;
        unset($this->schema[$this->_parent_field]['filter']);
    }
    public function get_parent_value() {
        return $this->_parent_value;
    }
    public function get_all_by_parent($parent_value){
        $this->_database->where_in($this->_table_alias.'.'.$this->_parent_field, $parent_value);

        return $this->get_all();
    }
}
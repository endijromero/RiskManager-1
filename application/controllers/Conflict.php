<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Conflict
 */
class Conflict extends Manager_base {
    public function __construct() {
        parent::__construct();
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "conflict",
            "view"   => "conflict",
            "model"  => "m_conflict",
            "object" => "Xung Đột",
        );
    }
}
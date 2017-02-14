<?php
/**
 * Created by IntelliJ IDEA.
 * User: admin
 * Date: 2/14/2017
 * Time: 6:18 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Risk_type
 */
class Risk_type extends Manager_base {
    public function __construct() {
        parent::__construct();
    }

    public function setting_class() {
        $this->name = Array(
            "class"  => "risk_type",
            "view"   => "risk_type",
            "model"  => "m_risk_type",
            "object" => "Loại rủi ro",
        );
    }
}
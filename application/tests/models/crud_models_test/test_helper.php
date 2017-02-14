<?php

/**
 * We also need to fake the inflector
 */
function singular($name) {
    return 'comment';
}

function plural($name) {
    return 'records';
}

/**
 * Let our tests know about our callbacks
 */
class MY_Model_Test_Exception extends Exception {
    public $passed_object = FALSE;

    public function __construct($passed_object, $message = '') {
        parent::__construct($message);
        $this->passed_object = $passed_object;
    }
}

class Callback_Test_Exception extends MY_Model_Test_Exception {
    public function __construct($passed_object) {
        parent::__construct($passed_object, 'Callback is being successfully thrown');
    }
}
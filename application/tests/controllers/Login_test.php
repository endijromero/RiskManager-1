<?php

/**
 * Created by PhpStorm.
 * User: miunh
 * Date: 15-Jun-16
 * Time: 3:56 PM
 */
class Login_test extends TestCase {
    public function test_index() {
        $output = $this->request('GET', ['demo_login', 'index']);
        $this->assertContains('<title>', $output);
    }


}
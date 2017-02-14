<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 28/06/16
 * Time: 10:01
 */
class M_demo_user_test extends TestCase {

    /**
     * @var M_demo_user
     */
    var $model;

    public function setUp() {
        $this->resetInstance();
        $this->CI->load->model('M_demo_user');
        $this->model = $this->CI->M_demo_user;
    }

    public function test_join_role_table() {
        $this->CI->db = $this->getMockBuilder('CI_DB_query_builder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->verifyInvoked($this->CI->db, "select", ["m.*, g.name as role_name, g.id as role_id"]);
        $this->verifyInvokedMultipleTimes($this->CI->db, "join", 2, [
            ["ion_users_groups as ug", "m.id=ug.user_id"],
            ["ion_groups as g", "ug.group_id=g.id"],
        ]);
        $this->model->join_role_table();
    }

    public function test_get_status() {
        $result = [
            '1' => 'Kich hoat',
            '0' => 'Khoa',
        ];
        $this->assertEquals($result, $this->model->get_status());
    }

    /**
     * @dataProvider get_status_text_provider
     */
    public function test_get_status_text($input, $expected) {
        $this->assertEquals($expected, $this->model->get_status_text($input));
    }

    public function get_status_text_provider() {
        return [
            'case 1' => [0, 'Khoa'],
            'case 2' => [1, 'Kich hoat'],
            'case 3' => [3, "3"],
        ];
    }
}
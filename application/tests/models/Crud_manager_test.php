<?php

/**
 * Created by IntelliJ IDEA.
 * User: phamtrong
 * Date: 27/06/16
 * Time: 14:21
 */
class Crud_manager_test extends TestCase {

    /**
     * @var M_Demo_manager
     */
    protected $model;

    /* --------------------------------------------------------------
     * TEST INFRASTRUCTURE
     * ------------------------------------------------------------ */

    public function setUp() {
        $this->resetInstance();
        $this->model = new M_Demo_manager();
    }

    /* --------------------------------------------------------------
     * NO DEPENDENCE SCHEMA METHOD
     * ------------------------------------------------------------ */

    public function test_get_primary_key() {
        $result = $this->model->get_primary_key();
        $this->assertEquals("id", $result);
    }

    /**
     * @dataProvider filter_data_where
     */
    public function test_get_list_filter_where($data) {
        $this->get_list_filter($data);
    }

    /**
     * @dataProvider filter_data_where_in
     */
    public function test_get_list_filter_where_in($data) {
        $this->get_list_filter($data);
    }

    /**
     * @dataProvider filter_data_like
     */
    public function test_get_list_filter_like($data) {
        $this->get_list_filter($data);
    }

    /**
     * @dataProvider filter_data_limit
     */
    public function test_get_list_filter_limit($data) {
        $this->get_list_filter($data);
    }

    /**
     * @dataProvider filter_data_post
     */
    public function test_get_list_filter_post($data) {
        $this->get_list_filter($data);
    }

    /**
     * @dataProvider filter_data_order
     */
    public function test_get_list_filter_order($data) {
        $this->get_list_filter($data);
    }

    protected function get_list_filter($data) {
        $result_fake = Array('fake_result1', 'fake_result2');
        $this->model->_database = $this->getMockBuilder('CI_DB_query_builder')
            ->disableOriginalConstructor()
            ->getMock();
        $db_result = $this->getMockBuilder("CI_DB_Result")
            ->disableOriginalConstructor()
            ->getMock();
        $this->model->_database->method('get')->willReturn($db_result);
        $db_result->method('result')->willReturn($result_fake);

        $this->_filter_prepare($data);
        $param = [];
        foreach ($data as $item) {
            $param[] = $item[0];
        }
        $result = $this->model->get_list_filter($param[0], $param[1], $param[2], $param[3], $param[4], $param[5]);
        $this->assertEquals($result, $result_fake);
    }


    /**
     * @dataProvider filter_data_where
     */
    public function test_get_list_filter_count_where($data) {
        $this->get_list_filter_count($data);
    }

    /**
     * @dataProvider filter_data_where_in
     */
    public function test_get_list_filter_count_where_in($data) {
        $this->get_list_filter_count($data);
    }

    /**
     * @dataProvider filter_data_like
     */
    public function test_get_list_filter_count_like($data) {
        $this->get_list_filter_count($data);
    }

    protected function get_list_filter_count($data) {
        $result_fake = 10;
        $this->model->_database = $this->getMockBuilder('CI_DB_query_builder')
            ->disableOriginalConstructor()
            ->getMock();
        $this->model->_database->method('count_all')->willReturn($result_fake);
        $this->_filter_prepare($data);
        $param = [];
        foreach ($data as $item) {
            $param[] = $item[0];
        }
        $result = $this->model->get_list_filter_count($param[0], $param[1], $param[2]);
        $this->assertEquals($result, $result_fake);
    }

    protected function _filter_prepare($data_provider) {
        $where = $data_provider[0][1];
        if ($where !== NULL) {
            $this->verifyInvokedMultipleTimes($this->model->_database, 'where', 2, [
                $where,
                ["m.deleted", $this->equalTo(FALSE)],
            ]);
        } else {
            $this->verifyInvoked($this->model->_database, 'where', ["m.deleted", $this->equalTo(FALSE)]);
        }
        $where_in = $data_provider[1][1];
        if ($where_in !== NULL) {
            $this->verifyInvoked($this->model->_database, 'where_in', $where_in);
        } else {
            $this->verifyNeverInvoked($this->model->_database, 'where_in');
        }
        $like = $data_provider[2][1];
        if ($like !== NULL) {
            $this->verifyInvoked($this->model->_database, 'like', $like);
        } else {
            $this->verifyNeverInvoked($this->model->_database, 'like');
        }
        $limit = $data_provider[3][0];
        $post = $data_provider[4][0];
        if ($limit > 0) {
            $this->verifyInvoked($this->model->_database, 'limit', [$limit, $post]);
        } else {
            $this->verifyNeverInvoked($this->model->_database, 'limit');
        }

        $order = $data_provider[5][1];
        if ($order !== NULL) {
            $this->verifyInvoked($this->model->_database, 'order_by', $order);
        } else {
            $this->verifyNeverInvoked($this->model->_database, 'order_by');
        }

    }


    public function filter_data($case) {
        $data = [
            "where"    => [
                'where array'  => [['where_col' => 'where_value'], [['where_col' => 'where_value']]],
                'where string' => ["where_col=where_value", NULL],
                'where int'    => [1, ['m.id', 1]],
            ],
            "where_in" => [
                'where_in array[array]'  => [['where_in_col' => [1, 2, 3]], ['where_in_col', [1, 2, 3]]],
                'where_in array[string]' => [['where_in_col' => "1,2,3"], ['where_in_col', "1,2,3"]],
                'where_in array[std]'    => [['where_in_col' => new stdClass()], NULL],
                'where_in std'           => [new stdClass(), NULL],
                'where_in string'        => ["where in string", NULL],
            ],
            "like"     => [
                'like array'  => [['like_col' => 'like_value'], ['like_col', 'like_value']],
                'like string' => ['like string', NULL],
            ],
            "limit"    => [
                [0, NULL],
                [10, NULL],
            ],
            "post"     => [
                [0, [10, 0]],
                [10, [10, 10]],
            ],
            "order"    => [
                [NULL, ['m.id', 'DESC']],
                [['order_col' => 'ASC'], ['order_col', 'ASC']],
                ['order_col ASC', ['order_col ASC']],

            ],
        ];
        $data_return = Array();

        foreach ($data[$case] as $main_k => $main_v) {
            $temp = [];
            foreach ($data as $key => $data_item) {
                if ($key == $case) {
                    $temp[] = $data[$key][$main_k];
                } else {
                    $first_e = array_slice($data[$key], 0, 1);
                    $temp[] = array_shift($first_e);//$data[$key][0];
                }
            }
            $data_return[$main_k] = [$temp];
        }
        return $data_return;
    }

    public function filter_data_where() {
        return $this->filter_data("where");
    }

    public function filter_data_where_in() {
        return $this->filter_data("where_in");
    }

    public function filter_data_like() {
        return $this->filter_data("like");
    }

    public function filter_data_limit() {
        return $this->filter_data("limit");
    }

    public function filter_data_post() {
        return $this->filter_data("post");
    }

    public function filter_data_order() {
        return $this->filter_data("order");
    }

}


class M_Demo_manager extends Crud_manager {

}
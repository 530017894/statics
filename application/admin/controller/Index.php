<?php

namespace app\admin\controller;

use Elasticsearch\ClientBuilder;

/**
 * 后台入口
 * Class Index
 *
 * @package app\admin\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:12
 */
class Index extends BaseController
{
    /**
     * 后台首页
     *
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:14
     */
    public function index()
    {

        return $this->fetch();
    }

    public function test()
    {
        echo microtime_float();
        echo "<br>";

        $client = ClientBuilder::create()->setHosts(config('es.'))->build();
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'body' => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];
        $response = $client->search($params);
        echo microtime_float();

        halt($response);
    }
}

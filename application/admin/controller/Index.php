<?php

namespace app\admin\controller;


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
        @set_time_limit(0);
        for ($i = 0; $i < 10000000; $i++) {
            $platform = array_rand([1, 2, 3, 4, 5],3);
            \app\admin\model\Projects::create([
                'name' => getRndWords(6),
                'platform' => join(',', $platform),
                'domain' => $i,
                'is_static' => '1',
                'user_account' => rand(1000, 9999),
                'status' => 1
            ]);
        }
    }
}

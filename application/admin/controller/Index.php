<?php

namespace app\admin\controller;


use think\Db;
use think\facade\Log;

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
        Log::write($msg);
    }
}

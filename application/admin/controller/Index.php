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
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:14
     */
    public function index()
    {

        return  $this->fetch();
    }

    /**
     * 欢迎页
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:13
     */
    public function welcome()
    {
        return $this->fetch();
    }
}

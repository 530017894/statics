<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * 登录控制器
 * Class Login
 *
 * @package app\admin\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:11
 */
class Login extends Controller
{
    /**
     * 登录页
     *
     * @return \think\Response
     */
    public function index()
    {
        return  $this->fetch();
    }

}

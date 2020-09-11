<?php

namespace app\admin\controller;

use app\common\facade\Response;
use app\admin\model\Users;
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
class Login extends BaseController
{

    /**
     * 登录页
     *
     * @return \think\Response
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $param = $this->request->param();
            try {
                $this->validate($param, [
                    'user_name|请输入账号' => 'require',
                    'password|请输入密码' => 'require'
                ]);
            } catch (\Exception $exception) {
                return Response::fail($exception->getMessage());
            }
            $user = Users::login($param['user_name'], $param['password']);
            if (!$user) {
                return Response::fail($user);
            }
            $user->hidden(['password']);
            cookie('user',json_encode($user),86400*7);
            return Response::success($user);
        }
        return $this->fetch();
    }

    public function test()
    {

    }

}

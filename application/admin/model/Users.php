<?php

namespace app\admin\model;

use app\common\controller\Response;

/**
 * 用户模型
 * Class Users
 *
 * @package app\common\model
 * author <马良 1826888766@qq.com>
 * time 2020/9/11 9:57
 */
class Users extends BaseModel
{
    /**
     * 登录判断
     * @param string $name 登录用户名
     * @param string $password 登录密码
     *
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/11 13:48
     */
    public static function login($name, $password)
    {
        $user = self::where('name', 'like', $name)->where('status',1)->find();
        if (!$user) {
            return Response::USER_FAIL;
        }
        if (!verifyPasswrod($password, $user->password)) {
            return Response::PASSWORD_FAIL;
        }
        return $user;
    }
}

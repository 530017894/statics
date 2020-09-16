<?php

namespace app\admin\controller;

use app\admin\model\Users;
use app\admin\facade\Response;

class User extends BaseController
{

    /**
     * 修改密码
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:39
     */
    public function password()
    {
        if ($this->request->isAjax()) {
            $param = $this->request->param();
            $rule = [
                'old_password|旧密码' => 'require',
                'new_password|新密码' => 'require|min:6',
                'confirm_password|确认密码' => 'require|confirm:new_password',
                'captcha|验证码' => 'require|captcha',
            ];
            try {

                $this->validate($param, $rule);

            } catch (\Exception $exception) {
                return Response::instance()->fail(-1, $exception->getMessage());
            }
            $password = createPassword($param['new_password']);
            $where = ['id' => $this->user['id']];
            $user = Users::where($where)->find();
            $user->password = $password;
            if ($user->save()) {
                return Response::instance()->success($user);
            }
            return Response::instance()->fail(-1, '系统错误,修改密码失败');
        }
        return $this->fetch();
    }
}

<?php

namespace app\admin\controller;

use app\admin\model\Users;
use app\admin\facade\Response;

class User extends BaseController
{
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
            $where = ['id' => $this->getUser()['id']];
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

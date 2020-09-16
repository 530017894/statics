<?php

namespace app\admin\controller;


use app\admin\facade\Response;
use app\admin\model\UserPermission;
use app\admin\model\Users;
use think\Db;

class Permission extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        if (!$this->is_admin) {
            $this->error('没有权限！');
        }
    }

    /**
     * 授权管理
     *
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:43
     */
    public function index()
    {
        //获取项目数据
        if ($this->request->isAjax()) {
            $where = [];
            $limit = $this->request->param('limit', 10);
            $where['status'] = 1;
            $data = Users::where($where)->order('ctime desc')->paginate($limit)->toArray();
            return Response::success($data);
        }
        return $this->fetch();
    }

    public function create()
    {
        return $this->fetch();
    }

    public function permission($id)
    {
        $permission = UserPermission::where('user_id', $id)->find();
        $projects = \app\admin\model\Projects::where('id', 'in', array_keys($permission['permission']))->field('id,name')->select();
        $this->assign('projects', $projects);
        $permissions = [];
        foreach ($permission['permission'] as $key => $item) {
            $permissions[$key] = $item['permission'];
        }
        $this->assign('permissions', $permissions);
        return $this->fetch();
    }

    public function password()
    {
        if ($this->request->isAjax()) {
            $param = $this->request->param();
            $rule = [
                'new_password|新密码' => 'require|min:6',
                'confirm_password|确认密码' => 'require|confirm:new_password',
                'captcha|验证码' => 'require|captcha',
                'id|用户id' => 'require'
            ];
            try {
                $this->validate($param, $rule);

            } catch (\Exception $exception) {
                return Response::instance()->fail(-1, $exception->getMessage());
            }
            $password = createPassword($param['new_password']);
            $where = ['id' => $this->param['id']];
            $user = Users::where($where)->find();
            $user->password = $password;
            if ($user->save()) {
                return Response::instance()->success($user);
            }
            return Response::instance()->fail(-1, '系统错误,修改密码失败');
        }
        $this->assign('id', $this->param['id']);
        return $this->fetch();
    }

    /**
     * 保存用户权限
     *
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 15:31
     */
    public function save()
    {
        Db::startTrans();
        try {

            $rule = [
                'name' => 'require|unique:users',
                'nickname|昵称' => 'require',
                'permissions|权限' => 'require'
            ];
            $this->validate($this->param, $rule, [
                'name.unique' => '账号已存在',
                'name.require' => '请输入账号',
                'nickname.require' => '请输入昵称',
                'permissions.require' => '请选择权限',
            ]);
            $password = createPassword('chengya');
            $user = Users::create([
                'name' => $this->param['name'],
                'password' => $password,
                'nickname' => $this->param['nickname'],
                'remark' => $this->param['remark']]);
            if ($user->id) {
                $permission = [];
                foreach ($this->param['permissions'] as $key => $val) {
                    $permission[$key] = [
                        'permission' => $val
                    ];
                }
                $permission = UserPermission::create([
                    'user_id' => $user->id,
                    'permission' => json_encode($permission)
                ]);
                if ($permission->id) {
                    Db::commit();
                    return Response::instance()->success($user);
                }
                throw new \Exception('系统错误，新增用户权限失败');
            }
            throw new \Exception('系统错误，新增用户失败');
        } catch (\Exception $exception) {
            Db::rollback();
            return Response::instance()->fail(-1, $exception->getMessage());
        }
    }

    public function edit($id)
    {
        $user = Users::get($id);
        $permission = UserPermission::where('user_id', $user->id)->find();
        $active_ids = [];

        foreach ($permission['permission'] as $key => $item) {
            $active_ids[$key] = $item['permission'];
        }
        $active_project = \app\admin\model\Projects::where('id', 'in', array_keys($active_ids))->select();
        $active_projects = [];
        foreach ($active_project as $item) {
            $active_projects[$item->id] = $item;
        }
        $this->assign('data', [
            'user' => $user,
            'permission' => $permission,
            'active_ids' => $active_ids,
            'active_project' => $active_projects
        ]);

        return $this->fetch();
    }

    public function update($id)
    {
        Db::startTrans();
        try {

            $rule = [
                'name' => 'require|unique:users,' . $id,
                'nickname' => 'require',
                'permissions' => 'require',
                'id' => 'require'
            ];
            $this->validate($this->param, $rule, [
                'id.require' => '用户id',
                'name.unique' => '账号已存在',
                'name.require' => '请输入账号',
                'nickname.require' => '请输入昵称',
                'permissions.require' => '请选择权限',
            ]);
            $user = Users::where('id', $id)->update([
                'name' => $this->param['name'],
                'nickname' => $this->param['nickname'],
                'remark' => $this->param['remark']]);
            $permission = [];
            foreach ($this->param['permissions'] as $key => $val) {
                $permission[$key] = [
                    'permission' => $val
                ];
            }
            UserPermission::where('user_id', $id)->update([
                'permission' => json_encode($permission)
            ]);
            Db::commit();
            return Response::instance()->success($user);
        } catch (\Exception $exception) {
            Db::rollback();
            return Response::instance()->fail(-1, $exception->getMessage());
        }
    }

    public function delete($id)
    {
        $user = Users::get($id);
        if (!$user) {
            return Response::instance()->fail(-1, '账户不存在');
        }
        Users::destroy($id);
        UserPermission::where('user_id', $id)->delete();
        return Response::instance()->success();
    }
}

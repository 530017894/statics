<?php

namespace app\admin\controller;

use app\admin\model\UserPermission;
use app\admin\facade\Response;
use think\Db;
use think\Request;
use app\admin\model\Projects as ProjectsModel;

class Projects extends BaseController
{
    public function initialize()
    {
        parent::initialize();
        if (!$this->is_admin) {
            $this->error('没有权限！');
        }
    }
    /**
     * 项目管理
     *
     * @return mixed|\think\response\Json
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:40
     */
    public function index()
    {
        //获取项目数据
        if ($this->request->isAjax()) {
            $where = [];
            $limit = $this->request->param('limit', 10);
            //用户id
            $name = $this->request->param("name");
            if ($name) {
                $where[] = array('name', "like", "%" . $name . "%");
            }
            $where[] = ['status', '=', 1];
            // 非超级管理管理
            if (!$this->isAdmin()) {
                $where[] = ['id', 'in', $this->getProjectIds()];
            }
            $data = ProjectsModel::where($where)->order('ctime','desc')->paginate(10)->toArray();
            return Response::success($data);
        }
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return $this->fetch();
    }


    /**
     * 保存新建的资源
     *
     * @return \think\Response
     */
    public function save()
    {
        $param = $this->request->param();
        $rule = [
            'name|项目名称'=>'require',
            'platform|平台'=>'require'
        ];
        Db::startTrans();
        try {
            $this->validate($param, $rule);
            $projects = ProjectsModel::create($param);
            ProjectsModel::createModule($projects);
            Db::commit();
            // 全部完成后创建对应表
        } catch (\Exception $exception) {
            Db::rollback();
            return Response::instance()->fail(-1, $exception->getMessage());
        }
        return Response::instance()->success($projects);
    }

    /**
     * 显示指定的资源
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function edit($id)
    {
        $project = ProjectsModel::get($id);
        $this->assign('project', $project);
        return $this->fetch();
    }

    /**
     * 保存更新的资源
     *
     * @param \think\Request $request
     * @param int            $id
     *
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $projects = ProjectsModel::get($id);
        if (!$projects) {
            return Response::instance()->fail(-1, "项目不存在");
        }
        $projects->data($request->param());
        $res = ProjectsModel::cache('projects-select')->where('id', $id)->update($request->param());
        if ($res) {
            return Response::instance()->success($projects);
        }
        return Response::instance()->fail(-1, "系统错误，保存失败");

    }

    /**
     * 删除指定资源
     *
     * @param int $id
     *
     * @return \think\Response
     */
    public function delete($id)
    {
        $project = ProjectsModel::get($id);
        if (!$project) {
            return Response::instance()->fail(-1, "项目不存在");
        }
        $project->status = 0;
        if ($project->save()) {
            return Response::instance()->success();
        }
        return Response::instance()->fail(-1, "系统错误，删除失败");
    }

    public function isAdmin()
    {
        return $this->user['id'] == 1;
    }
}

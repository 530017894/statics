<?php

namespace app\admin\controller;

use app\admin\model\UserPermission;
use app\admin\facade\Response;
use think\Db;
use think\Request;
use app\admin\model\Projects as ProjectsModel;

class Projects extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
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
                $where['name'] = array("like", "%" . $name . "%");
            }
            $where['status'] = 1;
            $data = ProjectsModel::where($where)->withAttr('platform')->order('ctime desc')->paginate($limit)->toArray();
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
     * @param \think\Request $request
     *
     * @return \think\Response
     */
    public function save()
    {
        $param = $this->request->param();
        $rule = [];
        Db::startTrans();
        try {
            $this->validate($param, $rule);
            $projects = ProjectsModel::create($param);
            if ($projects->id) {
                UserPermission::add($projects->id, 1, $this->getUser()['id']);
            }else{
                throw new \Exception('创建项目失败');
            }
            Db::commit();
            // 全部完成后创建对应表
            ProjectsModel::createModule($projects);
        } catch (\Exception $exception) {
            Db::rollback();
            return \response($exception);
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
        if ($projects->save()) {
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
}

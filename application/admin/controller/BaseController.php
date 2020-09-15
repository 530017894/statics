<?php


namespace app\admin\controller;


use app\admin\model\UserPermission;
use think\Controller;

class BaseController extends Controller
{
    /**
     * @var array 用户信息
     */
    protected $user = null;
    protected $permission = null;
    protected $project = null;
    protected $param = [];
    /**
     * @var bool  验证失败抛出异常
     */
    protected $failException = true;

    public function initialize()
    {

        $user = $this->getUser();
        if ($user == false) {
            $this->redirect(url('login/index'));
        }
        $this->param = $this->request->param();
        /** 检测是否传入项目id */
        if (isset($this->param['project_id'])) {
            cookie('project_id', $this->param['project_id']);
        } else {
            if (!cookie('project_id') && $this->request->controller() != 'Projects') {
                $this->redirect(url('projects/index'));
            }
        }

        $permission = $this->getPermission();
        if ($permission == false) {
            $this->error('你没有权限访问', url('login/logout'));
        }
        $project = $this->getProject();
        if ($project == false) {
            $this->error('项目已删除，或不存在', url('login/logout'));
        }
        $this->getProjects();

        /** 检测是否选择平台 */
        if (isset($this->param['platform_id'])) {
            cookie('platform_id', $this->param['platform_id']);
        } else {
            if (!cookie('platform_id')) {
                cookie('platform_id', $this->project->platform[0]);
            }
        }
        $this->assign('platform_id', cookie('platform_id'));
        $this->assign('where', []);
    }

    /**
     * 获取权限
     *
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/15 17:11
     */
    public function getPermission()
    {
        $permission = UserPermission::where(['user_id' => $this->user['id']])->find();
        if (!$permission) {
            return false;
        } else {
            $this->permission = $permission->permission;
            return true;
        }
    }

    /**
     * 获取当前选择的项目或默认的一个项目
     *
     * @return bool
     * author <马良 1826888766@qq.com>
     * time 2020/9/15 17:12
     */
    public function getProject()
    {
        $project_id = cookie('project_id') ?: $this->getProjectIds()[0];
        $project = \app\admin\model\Projects::get($project_id);
        if (!$project) {
            return false;
        }
        $this->project = $project;
        $this->assign('project', $project);
        $this->assign('permission', $this->permission[$project_id]['permission']);
        return true;
    }

    public function getProjects()
    {
        $projects = \app\admin\model\Projects::where('id', 'in', $this->getProjectIds())->select();
        $this->projects = $projects;
        $this->assign('projects', $projects);
        return true;
    }

    /**
     * 获取所有权限的项目ID
     *
     * @return array
     * author <马良 1826888766@qq.com>
     * time 2020/9/15 17:12
     */
    public function getProjectIds()
    {
        return array_keys($this->permission);
    }

    public function getUser()
    {
        $user = cookie('user');
        if (!$user) {
            return false;
        }
        $user = json_decode($user, true);
        $this->assign('user', $user);
        $this->user = $user;
        return true;
    }
}
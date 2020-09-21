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
    /**
     * @var null 所有权限
     */
    protected $permission = null;
    /**
     * @var \app\admin\model\Projects 当前项目
     */
    protected $project = null;
    /**
     * @var array 本次请求的数据
     */
    protected $param = [];
    /**
     * @var bool  验证失败抛出异常
     */
    protected $failException = true;
    protected $is_admin = true;

    /**
     * 初始化
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:47
     */
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
        }

        $permission = $this->getPermission();
        if ($permission == false) {
            $this->error('你没有权限访问', url('login/logout'));
        }

        $project = $this->getProject();
        if ($project == false && !$this->is_admin) {
            $this->error('项目已删除，或不存在', url('login/logout'));
        } else if ($project == false && $this->is_admin && $this->request->controller() != "Projects") {
            $this->redirect(url('projects/index'));
        }
        $this->getProjects();

        /** 检测是否选择平台 */
        if (isset($this->param['platform_id'])) {
            cookie('platform_id', $this->param['platform_id']);
        } else {
            if (!cookie('platform_id') && $this->project) {
                cookie('platform_id', $this->project->platform[0]);
            }
        }
        $this->assign('platform_id', cookie('platform_id'));
        $this->assign('where', []);
        $this->assign('is_admin', $this->is_admin);
        $platform_config = config('system.platform');
        $this->assign('platform_config', $platform_config);
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
            if (!$this->is_admin) {
                return false;
            }
            return true;
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
        $project_id = cookie('project_id');
        $where = [];
        if ($project_id) {
            $where['id'] = $project_id;
        }
        $project = \app\admin\model\Projects::where($where)->where('status', 1)->find();
        if (!$project) {
            $project = \app\admin\model\Projects::where('id', 'in', $this->getProjectIds())->where('status', 1)->find();

            /**
             * 拥有的权限中 有可管理的项目
             */
            if ($project) {
                $project_id = $project['id'];
                cookie('project_id', $project_id);
                $this->redirect(url('index/index'));
            }
        }
        $this->project = $project;
        $this->assign('project', $project);
        if (!$this->is_admin) {
            if (!$project) {
                return false;
            }
            $this->assign('permission', $this->permission[$project->id]['permission']);
        } else {
            $this->assign('permission', 1);
        }
        return true;
    }

    /**
     * 获取所有拥有权限的项目
     *
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:31
     */
    public function getProjects()
    {
        $projects = \app\admin\model\Projects::where('id', 'in', $this->getProjectIds())->where('status', 1)->field('id,name')->select();
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
        if (!$this->is_admin) {
            return array_keys($this->permission);
        }
        return \app\admin\model\Projects::where('status', 1)->cache('project_select')->column('id');
    }

    /**
     * 获取用户
     *
     * @return bool
     * author <马良 1826888766@qq.com>
     * time 2020/9/16 8:32
     */
    public function getUser()
    {
        $user = cookie('user');
        if (!$user) {
            return false;
        }
        $user = json_decode($user, true);
        $this->assign('user', $user);
        $this->user = $user;
        $this->is_admin = $user['id'] == 1;
        return true;
    }
}
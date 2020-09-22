<?php

namespace app\admin\controller;

use app\admin\facade\Response;
use app\admin\model\Mode;

class Module extends BaseController
{

    public function index()
    {
        return $this->fetch();
    }

    /**
     * 新增模块
     * author <马良 1826888766@qq.com>
     * time 2020/9/22 8:50
     */
    public function modeSave()
    {
        $rule = [
            'name|模块名称' => 'require',
            'type|模块类型' => 'require',
            'display|展示方式' => 'require',
            'project_id|项目Id' => 'require',
        ];
        try {
            $this->validate($this->param, $rule);
        } catch (\Exception $exception) {
            return Response::fail(-1, $exception->getMessage());
        }
        $data = Mode::project($this->project->id)->insert([
            'name' => $this->param['name'],
            'type' => $this->param['type'],
            'display' => $this->param['display'],
            'status' => 1,
            'ctime' => time(),
            'mtime' => time(),
        ]);
        return Response::success($data);
    }
}

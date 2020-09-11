<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Projects extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //获取项目数据
        if($this->request->isAjax()){
            $where      = [];
            $page       = $this->request->param('page', 1);
            $limit      = $this->request->param('limit', 15);
            //用户id
            $name       = $this->request->param("name");
            if($name){
                $where['name']=array("like","%".$name."%");
            }
            $testService=$this->testService;
            $data=$testService->getList($where,$page,$limit);
            return json($data);
        }
        $assign = [];
        $assign['hisiTabData'] = $this->tabData;
        $assign['hisiTabType'] = 3;

        return $this->assign($assign)->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}

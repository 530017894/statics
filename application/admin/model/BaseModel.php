<?php


namespace app\admin\model;


use think\Container;
use think\db\exception\DbException as Exception;
use think\Model;
use think\Paginator;

class BaseModel extends Model
{
    protected $moduleId = "";
    protected $createTime = "ctime";
    protected $updateTime = "mtime";


    /**
     * @param $moduleId 模块Id
     *                  author <马良 1826888766@qq.com>
     *                  time 2020/9/11 9:22
     */
    public function moduleId($moduleId)
    {
        $this->moduleId = $moduleId;
        /**
         * 根据模块设置数据表
         */
        return $this->table(str_replace('{moduleId}', $this->moduleId, $this->table));
    }

    /**
     * @return string
     * author <马良 1826888766@qq.com>
     * time 2020/9/11 9:15
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }



}
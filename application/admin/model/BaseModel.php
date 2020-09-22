<?php


namespace app\admin\model;


use think\Container;
use think\db\exception\DbException as Exception;
use think\Model;
use think\Paginator;

/**
 *
 * Class BaseModel
 *
 * @package app\admin\model
 * author <马良 1826888766@qq.com>
 * time 2020/9/22 9:39
 */
class BaseModel extends Model
{
    /**
     * @var mixed
     */
    private static $instance = null;
    protected $projectId = "";
    protected $project_str = "{project_id}";
    protected $createTime = "ctime";
    protected $updateTime = "mtime";

    public function __construct($data = [])
    {
        parent::__construct($data);
    }

    /**
     * @param $project_id
     *
     * @return BaseModel
     * author <马良 1826888766@qq.com>
     * time 2020/9/22 10:03
     */
    public static function project($project_id)
    {
        $instance = new static();
        $instance->table = str_replace($instance->project_str, $project_id, $instance->table);
        return $instance;
    }
}
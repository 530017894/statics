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
    public function project($project_id)
    {

        $this->table = str_replace($this->project_str, $project_id, $this->table);
        return $this;
    }

    public static function setProject($project_id)
    {
        /**
         * 根据模块设置数据表
         */
        return self::table(str_replace((new static())->project_str, $project_id, self::getTable()));
    }

    /**
     * @return string
     * author <马良 1826888766@qq.com>
     * time 2020/9/11 9:15
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @return mixed|static|null
     * author <马良 1826888766@qq.com>
     * time 2020/9/22 10:02
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * @return BaseModel|mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/22 10:11
     */
    public static function create($data = [], $field = null, $replace = false)
    {
        $model = self::instance();
        if (!empty($field)) {
            $model->allowField($field);
        }

        $model->isUpdate(false)->replace($replace)->save($data, []);

        return $model;
    }

    /**
     * 更新数据
     *
     * @access public
     *
     * @param array      $data  数据数组
     * @param array      $where 更新条件
     * @param array|true $field 允许字段
     *
     * @return static
     */
    public static function update($data = [], $where = [], $field = null)
    {
        $model = self::instance();

        if (!empty($field)) {
            $model->allowField($field);
        }

        $model->isUpdate(true)->save($data, $where);

        return $model;
    }

    /**
     * 删除记录
     *
     * @access public
     *
     * @param mixed $data 主键列表 支持闭包查询条件
     *
     * @return bool
     */
    public static function destroy($data)
    {
        if (empty($data) && 0 !== $data) {
            return false;
        }

        $model = self::instance();

        $query = $model->db();

        if (is_array($data) && key($data) !== 0) {
            $query->where($data);
            $data = null;
        } elseif ($data instanceof \Closure) {
            $data($query);
            $data = null;
        }

        $resultSet = $query->select($data);

        if ($resultSet) {
            foreach ($resultSet as $data) {
                $data->delete();
            }
        }

        return true;
    }
}
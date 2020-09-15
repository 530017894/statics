<?php

namespace app\admin\model;


class UserPermission extends BaseModel
{

    public function getPrmissionAttr($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param int $project_id 项目id
     * @param int $module_id
     * @param int $permission 权限
     * @param int $user_id
     *
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author <马良 1826888766@qq.com>
     * @time   2020/9/15 15:59
     */
    public static function add($project_id, $permission, $user_id)
    {
        $where = [
            'user_id' => $user_id
        ];
        $permissions = self::where($where)->find();
        if (!$permissions) {
            $res = self::create([
                'user_id' => $user_id,
                'permission' => json_encode([
                    $project_id => [
                        'permission' => $permission
                    ]
                ])
            ]);
            if (!$res['id']) {
                return "新增权限失败";
            }
        } else {
            if (isset($permissions->permission[$project_id]) && $permissions->permission[$project_id]['permission'] <= $permission) {
                return "已存在当前权限或更高权限";
            }
            $permissions->permission[$project_id] = [
                'permission' => $permission
            ];
            if (!$permissions->save()) {
                return "新增权限失败";
            }
        }
        return true;
    }
}

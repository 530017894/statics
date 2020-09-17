<?php

namespace app\admin\model;


class UserPermission extends BaseModel
{

    public function getPermissionAttr($value)
    {
        return json_decode($value, true);
    }

}

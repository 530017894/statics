<?php

namespace app\admin\model;


class Projects extends BaseModel
{
    public static function createModule(Projects $projects)
    {
        $sql = @file_get_contents(env('extend_path') . '/sql/cy_mode.sql');
        $sql = str_replace('MODULE_ID', $projects->id, $sql);
        $sql = str_replace("\r", "\n", $sql);
        $sql = str_replace("; \n", ";\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
            }
            $num++;
        }
        foreach ($ret as $item) {
            self::query($item);
        }
    }

    public function getPlatformAttr($value)
    {
        return explode(',', $value);
    }
}

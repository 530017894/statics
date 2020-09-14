<?php

namespace app\api\controller;

use app\common\Publish;
use think\Controller;
use think\Request;

/**
 *
 * Class Index
 *
 * @package app\api\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:16
 */
class Index extends Controller
{
    public function index()
    {
        return (new Publish())->put('test');
    }
}

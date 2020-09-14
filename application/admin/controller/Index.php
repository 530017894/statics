<?php

namespace app\admin\controller;

use Elasticsearch\ClientBuilder;
use OkStuff\PhpNsq\PhpNsq;

/**
 * 后台入口
 * Class Index
 *
 * @package app\admin\controller
 * author <马良 1826888766@qq.com>
 * time 2020/9/10 17:12
 */
class Index extends BaseController
{
    /**
     * 后台首页
     *
     * @return mixed
     * author <马良 1826888766@qq.com>
     * time 2020/9/10 17:14
     */
    public function index()
    {

        return $this->fetch();
    }

    public function test()
    {

        $phpnsq = new PhpNsq(config('nsq.'));

//normal publish
        $msg = $phpnsq->setTopic("test")->publish("Hello nsq.");

//defered publish
        $msg = $phpnsq->setTopic("test")->publishDefer("this is a defered message.", 10);
        var_dump($msg);

//multiple publish
        $messages = [
            "Hello, I am nsq client",
            "There are so many libraries developed by PHP",
            "Oh, no, PHP is not so good and slowly",
        ];
        $msg = $phpnsq->setTopic("test")->publishMulti(...$messages);
        halt($msg);
    }
}

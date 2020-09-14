<?php


namespace app\common;

use OkStuff\PhpNsq\PhpNsq;

class Publish
{
    private $phpnsq = null;

    private static $instance = null;

    public function __construct()
    {
        $this->phpnsq = new PhpNsq(config('nsq.'));
    }
    /**
     * @param string $msg
     *
     * @return mixed|\OkStuff\PhpNsq\Stream\Message|string|null
     * author <马良 1826888766@qq.com>
     * time 2020/9/14 16:57
     */
    public function put($msg = '')
    {
        $msg = $this->phpnsq->setTopic(config('nsq.topic'))->publish($msg);
        return $msg;
    }

    public function putDefer($message = "", $time = 10)
    {
        $msg = $this->phpnsq->setTopic(config('nsq.topic'))->publishDefer($message, $time);
        return $msg;
    }

    public function putMulti(array $messages = [])
    {
        $msg = $this->phpnsq->setTopic(config('nsq.topic'))->publishMulti(...$messages);
        return $msg;
    }

    /**
     * @return null
     */
    public static function getInstance()
    {
        if (!self::$instance){
            self::$instance = new static();
        }
        return self::$instance;
    }
}
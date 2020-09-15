<?php


namespace app\admin\controller;


use think\Controller;
use think\Model;

class BaseController extends Controller
{
    /**
     * @var Model 用户信息
     */
    private $user = null;
    /**
     * @var bool  验证失败抛出异常

     */
    protected $failException = true;

    public function initialize()
    {
        $user = cookie('user');
        if (!$user) {
            $this->redirect(url('login/index'));
        }
        $user = json_decode($user, true);
        $this->assign('user', $user);
        $this->user = $user;
    }

    /**
     * @return Model
     */
    public function getUser()
    {
        return $this->user;
    }
}
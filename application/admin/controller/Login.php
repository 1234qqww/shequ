<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use think\captcha\Captcha;
class Login extends Controller
{
    public function _initialize(){
        parent::_initialize();
    }

    public function login(){
        if(request()->isAjax()){
            return model('admin')->admin_login(input());
        }
        if(session('admin')){
            $admin=session('admin');
            if($admin['role_id']==1){
                return $this->redirect(url('index/index'));
            }else{
                return $this->redirect(url('index/indexs'));
            }
        }
        return $this->fetch(':login');
    }
    public function getcaptcha(){
        return getcaptcha(input('param.id'));
    }
    public function login_out(){
        session('admin',false);
        session('admin_id',false);
        session('allow_menu',false);
        return $this->success('退出成功!');
    }
}

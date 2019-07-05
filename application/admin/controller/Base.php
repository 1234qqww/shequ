<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use think\Request;
use think\Db;
class Base extends Auth
{
    public function _initialize(){
        parent::_initialize();
        //初始化
        if(!session('admin')){
            $this->redirect('Login/login');
        }
        //构造方法检查权限是否够使用功能
//        model('admin')->check_role(session('admin'));
//        if(!model('admin')->check_menu(strtolower(Request::instance()->controller()),strtolower(Request::instance()->action()))){
//            return $this->error('尚未获得权限!');
//        }
    }

//    public  function  return_table($data,$count,$message=''){
//        $arr['status']=0;
//        $arr['message']=$message;
//        $arr['total']=$count;
//        $arr['data']=$data;
//        dump($arr);
//        die();
//        return json_encode($arr);
//    }
}

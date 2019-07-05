<?php


namespace app\api\controller;


use think\Controller;

class Base extends Controller
{
    public function _initialize(){
        parent::_initialize();
        //初始化
       $param=$this->request->param();
       $token='hhtc12345678';
       md5($token);
       if(md5($param['token'])!=$token){
          return json(array('code'=>0,'msg'=>'非法操作！'));
       }
        //构造方法检查权限是否够使用功能
//        model('admin')->check_role(session('admin'));
//        if(!model('admin')->check_menu(strtolower(Request::instance()->controller()),strtolower(Request::instance()->action()))){
//            return $this->error('尚未获得权限!');
//        }
    }


}
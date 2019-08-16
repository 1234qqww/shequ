<?php


namespace app\api\controller;


use think\Controller;

class Base extends Controller
{
    public function _initialize(){
        parent::_initialize();
        //初始化
       $param=$this->request->param();
       $token='hhtc123456';
       if(!isset($param['token'])){
           return json(array('code'=>0,'msg'=>'非法操作！'));
       }
       if($param['token']!=md5($token)){
          return json(array('code'=>0,'msg'=>'非法操作！'));
       }
    }



}
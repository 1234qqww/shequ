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
       if(!isset($param['token'])){
           return json(array('code'=>0,'msg'=>'非法操作！'));
       }

       md5($token);
       if(md5($param['token'])!=$token){
          return json(array('code'=>0,'msg'=>'非法操作！'));
       }
    }



}
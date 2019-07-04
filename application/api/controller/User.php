<?php


namespace app\api\controller;


use think\Db;
use think\Model;

class User extends Base
{
    //查询用户详情
    public function index(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
       $user=Db::name('user')->where(['id'=>$param['userid']])->find();

       $arr=array('user'=>$user);
        return  json(array('code'=>1,'msg'=>'操作成功','data'=>$arr));
    }



    //查询用户收货地址
    public function address(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $userAddress=model('UserAddress');
        $Address=$userAddress->address($param['userid']);
        return  json(array('code'=>1,'msg'=>'操作成功','data'=>$Address));
    }

    //添加用户收货地址
    public function add_address(){
        $param=$this->request->param();

        if(!$param['user_id']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        if(!preg_match("/^1[345678]{1}\d{9}$/",$param['mobile'])){
            return json(array('code'=>0,'msg'=>'请输入正确的手机号码'));
        }
        unset($param['token']);
        $add_address=model('UserAddress')->add_address($param);        //新增收货地址
        if($param['is_default']==1){
            $rel=Db::name('user')->where(['id'=>$param['user_id']])->data(['address_id'=>$add_address])->update();    //修改用户设置的默认地址
            if(!$rel){
                return  json(array('code'=>0,'msg'=>'修改成功'));
            }
        }
        return  json(array('code'=>1,'msg'=>'添加成功'));
    }





}
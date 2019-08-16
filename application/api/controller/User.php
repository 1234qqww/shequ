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
            $rel=Db::name('user')->where(['id'=>$param['user_id']])->find();
            if(!empty($rel['address_id'])){
                Db::name('user_address')->where(['addressid'=>$rel['address_id']])->update(['is_default'=>0]);
            }

            $rel=Db::name('user')->where(['id'=>$param['user_id']])->data(['address_id'=>$add_address])->update();    //修改用户设置的默认地址
            if(!$rel){
                return  json(array('code'=>0,'msg'=>'修改成功'));
            }
        }
        return  json(array('code'=>1,'msg'=>'添加成功'));
    }

    //修改
    public function edit_address(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['user_id']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        if(isset($param['post'])){
            if(!preg_match("/^1[345678]{1}\d{9}$/",$param['mobile'])){
                return json(array('code'=>0,'msg'=>'请输入正确的手机号码'));
            }
            unset($param['post']);
            if($param['is_default']==1){
                $rel=Db::name('user')->where(['id'=>$param['user_id']])->find();

                if($param['addressid']!=$rel['address_id']){
                    Db::name('user')->where(['id'=>$param['user_id']])->update(['address_id'=>$param['addressid']]);
                    Db::name('user_address')->where(['addressid'=>$rel['address_id']])->update(['is_default'=>0]);
                }
            }
            Db::name('user_address')->where(['addressid'=>$param['addressid']])->update($param);

            return json(array('code'=>1,'msg'=>'修改成功'));
        }



        $user_address=Db::name('user_address')->where(['addressid'=>$param['id']])->find();
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$user_address));
    }


    //删除
    public function del_address(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['user_id']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        Db::name('user_address')->where(['addressid'=>$param['id']])->delete();
        $rel=Db::name('user')->where(['id'=>$param['user_id']])->find();

        if($param['id']==$rel['address_id']){
            Db::name('user')->where(['id'=>$param['user_id']])->update(['address_id'=>0]);
        }
        return  json(array('code'=>1,'msg'=>'删除成功'));

    }
    public function order(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['user_id']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $order1=   Db::name('order')->where(['user_id'=>$param['user_id'],'order_status'=>0])->count();         //待付款
        $order2=   Db::name('order')->where(['user_id'=>$param['user_id'],'pay_status'=>1,'shipping_status'=>0])->count();         //待发货
        $order3=    Db::name('order')->where(['user_id'=>$param['user_id'],'order_status'=>2])->count();         //已完成
        $order4=   Db::name('order')->where(['user_id'=>$param['user_id'],'order_status'=>3])->count();         //退款
        return  json(array('code'=>1,'msg'=>'成功','data'=>array('order1'=>$order1,'order2'=>$order2,'order3'=>$order3,'order4'=>$order4)));
    }






}
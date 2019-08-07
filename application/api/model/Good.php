<?php


namespace app\api\model;


use think\Db;
use think\Model;

class Good extends Model
{
    public function good_index($data){
        return Db::name('good')->where($data)->find();
    }
    //链表查询商户的后台登录账号
    public function good_admin($data){
       $good=Db::name('good')->where($data)->find();
       $admin=Db::name('admin')->where(['goodid'=>$good['id']])->find();

    }
    //商家入驻申请
    public function good_add($data){
        return    Db::name('good')->insert($data);

    }
    //查询商家数据
    public function getFind($field,$where){
     return   Db::name('good')->field($field)->where($where)->find();
    }
    public function oneData($id){
        return Db::name('good')->where('id',$id)->find();
    }
}
<?php


namespace app\api\model;


use think\Db;
use think\Model;

class UserAddress extends Model
{
    //查询地址
    public function address($userid){
       return Db::name('user_address')->where(['user_id'=>$userid])->select();

    }

    //添加地址
    public function add_address($param){
      return  Db::name('user_address')->insertGetId($param);
    }

}
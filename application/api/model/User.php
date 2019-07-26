<?php


namespace app\api\model;


use think\Db;
use think\Model;

class User extends Model
{

    public function user_find($where,$field){
       $user=Db::name('user')->where($where)->field($field)->find();
       $address='';
       if($user['address_id']){

           $address=Db::name('user_address')->where(['addressid'=>$user['address_id']])->find();
       }
       return $address;

    }

}
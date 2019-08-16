<?php

namespace app\api\model;
use think\Model;
use think\Db;
class UserModel extends Model {
    protected $table='hhtc_user';  //表名称
    public function lists(){
        return $this->select();
    }
    public function oneData($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 通过openid 来查询用户
     */
    public function open($openid){
        return $this->where('openid',$openid)->find();
    }
    /**
     * 修改用户余额
     */
    public function edit($param){
        return $this->where('id',$param['user_id'])->update(['user_money'=>$param['user_money']]);
    }
}
?>
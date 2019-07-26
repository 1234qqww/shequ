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
}
?>
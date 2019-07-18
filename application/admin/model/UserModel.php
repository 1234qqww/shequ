<?php

namespace app\admin\model;
use think\Model;
use think\Db;
class UserModel extends Model {
    protected $table='hhtc_user';  //表名称
    public function lists(){
        return $this->select();
    }
}
?>
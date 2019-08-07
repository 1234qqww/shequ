<?php

namespace app\api\model;
use think\Model;
class TrandModel extends Model {
    protected $table='hhtc_trand';  //表名称

    public function trandlist(){
      return $this->select();
    }
    /**
     * 动态详情
     */
    public function ondData($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 修改阅读量
     */
    public function editread($param){
        return $this->where('id',$param['trand_id'])->update(['read'=>$param['read']]);
    }
}
?>
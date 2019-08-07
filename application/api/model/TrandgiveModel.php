<?php

namespace app\api\model;
use think\Model;
class TrandgiveModel extends Model {
    protected $table='hhtc_trandgive';  //表名称
    public function sel($param){
        return $this->where('user_id',$param['user_id'])->where('trand_id',$param['trand_id'])->find();
    }

    /**
     * @param $param
     * @return false|int
     * 点赞
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['trand_id']=isset($param['trand_id'])?$param['trand_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * @param $param
     * @return false|int
     * 删除
     */
    public function del($param){
        return $this->where('user_id',$param['user_id'])->where('trand_id',$param['trand_id'])->delete();
    }
}
?>
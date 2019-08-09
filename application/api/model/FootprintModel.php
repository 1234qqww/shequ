<?php

namespace app\api\model;
use think\Model;
class FootprintModel extends Model {
    protected $table='hhtc_footprint';  //表名称

    public function onedata($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 查看商品是否浏览
     */
    public function iffootprint($param){
        return $this->where('user_id',$param['user_id'])->where('goods_id',$param['goods_id'])->find();
    }
    /**
     * 用户收藏商品
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['goods_id']=isset($param['goods_id'])?$param['goods_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d  H:i:s');
        return $this->save($data);
    }
    /**
     * 用户取消收藏
     */
    public function del($param){
        return $this->where('user_id',$param['user_id'])->where('goods_id',$param['goods_id'])->delete();
    }
    /**
     * 某用户浏览过的商品
     */
    public function selUser($user_id){
        return $this->where('user_id',$user_id)->select();
    }
}
?>
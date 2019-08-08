<?php

namespace app\api\model;
use think\Model;
class GroupModel extends Model {
    protected $table='hhtc_group';  //表名称

    /**
     * 查看拼团商品
     */
    public function lists(){
        return $this->with('goods')->select();
    }
    /**
     * 关联商品表
     */
    public function goods(){
        return $this->hasOne('Goods','id','goods_id');
    }

    /**
     * 通过商品id来获取团购商品
     */

    public function groupshop($goods_id){
        return $this->with('goods')->where('goods_id',$goods_id)->find();
    }



}
?>
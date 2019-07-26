<?php


namespace app\api\model;


use think\Db;
use think\Model;

class GoodsDiscount extends Model
{
    //查询优惠卷
    public function getSelect($where,$order,$field){

      return  Db::name('goods_discount')->field($field)->where($where)->order($order)->select();

    }


    public function getFind($where){

        return  Db::name('goods_discount')->where($where)->find();

    }


}
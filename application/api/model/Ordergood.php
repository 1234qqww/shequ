<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;
use think\Paginator;

class Ordergood extends Model
{
    protected $table='hhtc_order_goods';  //表名称
    /**
     * 通过商品id查询所有该商品的订单号
     */
    public  function order($goods_id){
        return $this->where('goods_id',$goods_id)->select();
    }
    /**
     * 订单状态修改未待发货
     */
    public function deliver ($id){
        return Db::name('hhtc_order')->where('id',$id)->update(['order_status'=>1]);
    }
    /**
     * 通过订单id查询对应的团购商品
     */
    public function regiment($order_id){
        return $this->where('order_id',$order_id)->find();
    }

}
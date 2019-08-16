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


    //查询订单下所有的商品

    public function order_goods_all($order_id){
      $order_goods=Db::name('order_goods')
                ->alias('o')
                ->join('goods g','g.id=o.goods_id')
                ->field('o.id,o.goods_id,o.order_id,o.goods_num,o.sku_id,g.id as gid,g.give_integral,g.is_reduce,g.store_count,g.goods_name')
                ->where(['o.order_id'=>$order_id])
                ->select();
      foreach ($order_goods as $k=>$v){
                if(!empty($v['sku_id'])){
                        $a=Db::name('goods_item_sku')->where(['id'=>$v['sku_id']])->select();
                        $order_goods[$k]['store_count']=$a['sku_store_count'];
                }
      }
      return $order_goods;
    }

}
<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class Order extends Model
{

    public function order_where($where){
     return   Db::name('order')
                ->alias('o')
                ->join('user_address u','o.user_address=u.addressid')
                ->field('o.id,o.order_sn,o.user_address,o.good_id,o.order_status,o.pay_status,o.shipping_status,o.pay_name,o.total_amount,o.order_amount,o.add_time,o.order_prom_type,u.addressid,u.consignee,u.mobile')
                ->where($where)
                ->order('add_time desc')
                ->paginate(15);
    }
    public function edit_order($where){

        $order=Db::name('order')
            ->alias('o')
            ->join('user_address u','o.user_address=u.addressid')
            ->join('user s','o.user_id=s.id' )
            ->field('o.id,o.order_sn,o.user_address,o.good_id,o.order_status,o.pay_status,o.shipping_status,o.pay_name,o.total_amount,o.shipping_price,o.coupon_price,o.marketing_price,o.order_amount,o.add_time,o.goods_price,o.pay_time,o.order_prom_type,u.addressid,u.consignee,u.mobile,u.province,u.city,u.area,u.address,s.id as userid,s.userName')
            ->where(['o.id'=>$where])
            ->find();
          $wuliu=Db::name('order_wuliu')->where(['order_id'=>$order['id']])->find();
          $goods=Db::name('order_goods')
               ->alias('o')
               ->join('goods g','g.id=o.goods_id')
               ->field('o.id,o.goods_id,o.goods_num,o.sku,o.price,g.id as goodsid,g.goods_name,g.original_img')
               ->where(['order_id'=>$where])
               ->select();
        return array('order'=>$order,'goods'=>$goods,'wuliu'=>$wuliu);

    }

}
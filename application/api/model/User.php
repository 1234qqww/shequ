<?php


namespace app\api\model;


use think\Db;
use think\Model;

class User extends Model
{

    public function user_find($where,$field){
       $user=Db::name('user')->where($where)->field($field)->find();
       $address='';
       if($user['address_id']){

           $address=Db::name('user_address')->where(['addressid'=>$user['address_id']])->find();
       }
       return $address;

    }
    public function GetUser($where,$field){


        return   Db::name('user')->where($where)->field($field)->find();

    }



    //订单提交，余额支付扣出余额，加积分，微信支付，加积分  根据商品减少库存方式减少库存,加销量
    public function order_sub($order,$pay_id,$user_id){
        $price=$order['order_amount'];//应付金额
        $price_num=0;
       if($order['order_prom_type']==1){
            $good_seckill=\model('good_seckill')->order_goods_all($order['id']);
            $price_num=$good_seckill['give_integral']*$good_seckill['goods_num'];
            $seckill=\model('good_seckill')->seckill($good_seckill['goods_id'],$user_id);
            if($seckill['code']!=1){
                return $seckill;
            }
            $res=\model('good_seckill')->get_list($seckill['data']['id'],$user_id);
            if($res){
                Db::name('good_seckill_list')->where(['id'=>$res['id']])->setInc('purchase');   //减少秒杀用户购买商品数量
            }else{
                \model('good_seckill')->get_list_add($user_id,$seckill['data']['id'],$good_seckill['goods_num']);
            }
            Db::name('good_seckill')->where(['id'=>$seckill['data']['id']])->setDec('quantity',$good_seckill['goods_num']);//减少可购买数量
            Db::name('good_seckill')->where(['id'=>$seckill['data']['id']])->setInc('quantitys',$good_seckill['goods_num']); //加已购买数量
       }else{
           $order_goods=\model('order_good')->order_goods_all($order['id']);   //查询订单下所有商品
           foreach ($order_goods as $k=>$v){
               $price_num+=$v['give_integral']*$v['goods_num'];
               if($v['is_reduce']==2){
                   \model('goods')->store_count($v['gid'],$v['goods_num'],$v['sku_id']);                //付款减库存
               }
                   \model('goods')->sales_sum($v['gid'],$v['goods_num']);                               // 加商品销量
           }
       }
        if($pay_id==2){
            $user=Db::name('user')->where(['id'=>$user_id])->setDec('user_money',$price);   //余额支付减余额
            if(!$user){
                return ['code'=>0,'msg'=>'扣款失败'];
            }
        }
       Db::name('user')->where(['id'=>$user_id])->setInc('jifen',$price_num);   //用户加积分
       Db::name('user')->where(['id'=>$user_id])->setInc('total_amount',$price);      //加消费累计
        return ['code'=>1,'msg'=>'成功'];

    }








}
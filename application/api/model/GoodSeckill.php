<?php


namespace app\api\model;


use think\Db;
use think\Model;

class GoodSeckill extends Model
{
    public function getFind($goods_id){
       return Db::name('good_seckill')->where(['goods_id'=>$goods_id])->find();



    }

    public function get_list($seckill_id,$user_id){

     return   Db::name('good_seckill_list')->where(['seckill_id'=>$seckill_id,'user_id'=>$user_id])->find();
    }

    public function seckill($goods_id,$user_id){
        $good_seckill=$this->getFind($goods_id);
        if(!$good_seckill){
            return ['code'=>0,'msg'=>'该商品不存在或已被删除'];
        }
        $now_time = strtotime($good_seckill['start_his'])-strtotime('today');
        if(is_int($now_time/7200)){      //双整点时间，如：10:00, 12:00
            $start_time = $now_time;
        }else{
            $start_time = floor($now_time/7200)*7200;
        }
        $end_time = $start_time+7200;   //结束时间
        $end_time=($end_time/60/60-1)<10?'0'.($end_time/60/60-1).':59:59':($end_time/60/60-1).':59:59';
        $end_time=strtotime(date('Y-m-d').' '.$end_time);               //结束时间时间戳
        $now=strtotime(date('Y-m-d H:i:s'));   //当前时间

        if($now>$end_time){
            return ['code'=>0,'msg'=>'抱歉！秒杀时间已结束。'];
        }
        if($now>strtotime($good_seckill['end_time'])){
            return ['code'=>0,'msg'=>'抱歉！秒杀活动已结束。'];
        }
        if($good_seckill['quantity']==0){
            return ['code'=>0,'msg'=>'商品已被抢购一空，请关注下次活动。'];
        }
        $seckill_list=$this->get_list($good_seckill['id'],$user_id);

        if($seckill_list){
            if($good_seckill['purchase']<=$seckill_list['purchase']){
                return ['code'=>0,'msg'=>'抱歉该商品限购'.$good_seckill['purchase'].'个，你已购'.$seckill_list['purchase'].'个'];
            }
        }
        return ['code'=>1,'msg'=>'','data'=>$good_seckill];
    }


//秒杀商品判断秒杀库存，秒杀时间
    public function order_goods_all($order_id){
     return  Db::name('order_goods')
            ->alias('o')
            ->join('goods g','g.id=o.goods_id')
            ->field('o.id,o.goods_id,o.order_id,o.goods_num,g.id as gid,g.give_integral,g.goods_name')
            ->where(['o.order_id'=>$order_id])
            ->find();
    }


    public function get_list_add($user_id,$seckill_id,$goods_num){
      return  Db::name('good_seckill_list')->insert(['seckill_id'=>$seckill_id,'user_id'=>$user_id,'purchase'=>$goods_num]);
    }





}
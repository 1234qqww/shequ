<?php


namespace app\api\controller;


use think\Db;

class GoodSeckill extends Base
{


    public function index(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $time=$param['time'];
        $now_time = strtotime($time)-strtotime('today');  //当前时间
        $date=date('Y-m-d');
        if(is_int($now_time/7200)){      //双整点时间，如：10:00, 12:00
            $start_time = $now_time;
        }else{
            $start_time = floor($now_time/7200)*7200;
        }
        $end_time = $start_time+7200;   //结束时间
        $start_time=($start_time/60/60)<10?'0'.($start_time/60/60).':00:00':($start_time/60/60).':00:00';
        $end_time=($end_time/60/60-1)<10?'0'.($end_time/60/60-1).':59:59':($end_time/60/60-1).':59:59';
        $where['start_time']=array('elt',$date);
        $where['end_time']=array('gt',date('Y-m-d H:i:s'));
        $where['start_his']=array('between', array($start_time,$end_time));
        $DetTime=$this->DetTime($where);
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$DetTime));
    }


    public function DetTime($where){
       $good_seckill=Db::name('good_seckill')
              ->alias('s')
              ->join('goods g','s.goods_id=g.id')
              ->field('s.id,s.goods_id,s.good_id,s.discount,s.quantity,s.quantitys,s.purchase,s.start_time,s.start_his,s.end_time,g.id as gid,g.goods_name,g.original_img,g.shop_price')
              ->where($where)
              ->select();
       foreach ($good_seckill as $k=>$v){
           $good_seckill[$k]['original_img']=url_imgs($v['original_img']);
           $good_seckill[$k]['price']=$v['shop_price']-$v['discount'];
           $good_seckill[$k]['stock']= $v['quantity']-$v['quantitys'];
       }
       return $good_seckill;

    }


}
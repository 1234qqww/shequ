<?php


namespace app\api\controller;


use think\Config;
use think\Db;

class Youhuijuan extends Base
{
    //商家发行优惠卷
    public function good_index(){
        $param=$this->request->param();
        unset($param['token']);

        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $where['goods_id']=$param['id'];
        $where['state']=1;
        $where['total']=array('neq',0);
        $end_time=date('Y-m-d H:i:s');
        $where['end_time'] = array('egt',$end_time);          //大于或等于
        $discount=model('goods_discount');
        $order='reduction asc';
        $field  = "id,DATE_FORMAT(start_time,'%Y-%m-%d') as start_time,DATE_FORMAT(end_time,'%Y-%m-%d ') as end_time,state,total,dis_name,goods_id,reduction,satisfy";
        $goods_discount= $discount->getSelect($where,$order,$field);//查询商家发行的优惠卷
        $userWhere['userid']=$param['userid'];
        $coupon=model('good_coupon');
        $user= $coupon->getSelect($userWhere);            //查询用户领取的优惠卷
        $good='';
        if($param['id']!=-1){
            $field='id,name';
            $where['id']=$param['id'];
            $good=model('good')->getFind($field,$where); //商户信息
        }
        foreach($goods_discount as $k=>$v){
            $goods_discount[$k]['receiving']=0;

            foreach ($user as $x=>$y){
                if($v['id']==$y['discount_id']){
                    $goods_discount[$k]['receiving']=1;                     //领取状态，已领取
                }
            }
        }

        $arr=array('coupon'=>$goods_discount,'good'=>$good);
        return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));

    }



    //用户优惠卷领取
    public function user_couponAdd(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $where['userid']=$param['userid'];
        $where['goods_id']=$param['goods_id'];
        $where['discount_id']=$param['id'];

        $count=model('good_coupon')->getSelect($where);    //用户领取的优惠卷
        if($count){
            return json(array('code'=>0,'msg'=>'已领取，请勿重复领取'));
        }


       $discount=model('goods_discount')->getFind(['id'=>$param['id']]);  //商家发布的优惠卷
        if($discount['total']==0){
            return json(array('code'=>0,'msg'=>'优惠卷已发放完毕，请刷新'));
        }

        $good_coupon=model('good_coupon')->getcouponAdd($param);
        if($good_coupon){

            Db::name('goods_discount')->where(['id'=>$param['id']])->setDec('total');
            return json(array('code'=>1,'msg'=>'领取成功'));
        }
        return json(array('code'=>0,'msg'=>'领取失败'));

    }

    //我的优惠卷
    public function user_mycoupon(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $good_coupon=model('good_coupon')->user_mycoupon($param['userid']);


        $state1=[];
        $state2=[];
        $state3=[];
        foreach ($good_coupon as $k=>$v){
                if($v['state']==1){
                    $state1[$k]=$v;
                }
                if($v['state']==2){

                    $state2[$k]=$v;
                }
                if($v['state']==3){
                    $state3[$k]=$v;
                }
        }
        $nav=array(['id'=>1,'name'=>'未使用','nums'=>count($state1)],['id'=>2,'name'=>'已使用','nums'=>count($state2)],['id'=>3,'name'=>'已过期','nums'=>count($state3)]);
        $arr=array('coupon'=>$good_coupon,'nav'=>$nav);
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$arr));
    }


}
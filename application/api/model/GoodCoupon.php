<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;

class GoodCoupon extends Model
{
    //用户优惠卷查找
    public function getSelect($where){
     return   Db::name('good_coupon')->where($where)->select();
    }

    //用户领取优惠卷

    public function getcouponAdd($data){
       $data['discount_id']=$data['id'];
        unset($data['id']);
        return   Db::name('good_coupon')->insert($data);
    }


    //用户优惠卷列表
    public function user_mycoupon($userid){
        $good_coupon =Db::name('good_coupon')
                      ->alias('g')
                      ->join('goods_discount d','g.discount_id=d.id')       //优惠卷
                      ->field('g.id,g.userid,g.discount_id,g.state,d.id as dis_id,d.end_time')
                      ->where(['g.userid'=>$userid,'g.state'=>1])
                      ->select();

        $now=date('Y-m-d H:i:s');
        foreach ($good_coupon as $k=>$v){
            if($v['end_time']<$now){
               Db::name('good_coupon')->where(['id'=>$v['id']])->update(['state'=>3]);  //改变优惠卷状态
            }
        }
//        DATE_FORMAT(d.start_time,'%Y-%m-%d') as d.start_time,DATE_FORMAT(d.end_time,'%Y-%m-%d ') as d.end_time,
        $coupon =Db::name('good_coupon')
                        ->alias('g')
                        ->join('goods_discount d','g.discount_id=d.id')       //优惠卷
                        ->field("g.id,g.userid,g.goods_id,g.discount_id,g.state,
                        d.id as dis_id,d.dis_name,d.reduction,d.satisfy,d.state as dis_state,
                        DATE_FORMAT(d.start_time,'%Y-%m-%d') as start_time,DATE_FORMAT(d.end_time,'%Y-%m-%d ') as end_time")
                        ->where(['g.userid'=>$userid])
                        ->select();
        $url=Config::get('host');
        foreach ($coupon as $k=>$v){
            if($v['goods_id']!=-1){
                $good=Db::name('good')->field('id,name,pic')->where(['id'=>$v['goods_id']])->find();
                $coupon[$k]['good_name']=$good['name'];

                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$good['pic'])){
                    $coupon[$k]['pic']=$url['url'].$good['pic'];
                }
            }else{
                $base_config=Config::get('base_config');
                $coupon[$k]['good_name']='平台自营';
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$base_config['imgs'])){
                    $coupon[$k]['pic']=$url['url'].$base_config['imgs'];
                }
            }
        }
        return $coupon;



    }



}
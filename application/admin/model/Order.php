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
    /**
     * 查询完成的订单
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('order_sn','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->with('good')->where('good_id','neq','-1')->limit($limit)->where('order_status',2)->where('pay',0)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 关联商户表
     */
    public function good(){
        return $this->hasOne('Good','id','good_id');
    }

    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('UserModel','id','user_id');
    }

    /**
     * 管理员转账
     */
    public function carry($param,$id){
        return $this->where('id',$id)->update(['pay'=>1,'carrymoney'=>$param['moneys']]);
    }
    /**
     * 商户转账订单
     */
    public function carrylist($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('order_sn','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->with('good')->where('pay','1')->where('good_id','neq','-1')->limit($limit)->where('order_status',2)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 分销商转账订单
     */
    public function retaillist($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('order_sn','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->with('retail')->where('pay','0')->where('good_id','-1')->limit($limit)->where('order_status',2)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 关联分销商表
     */
    public function retail(){
        return $this->hasOne('RetailModel','id','retail_id');
    }
    /**
     * 分销商转账记录
     */
    public function retaillists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('order_sn','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->with('retail')->where('pay','1')->where('good_id','-1')->limit($limit)->where('order_status',2)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }

    /**
     * 给分销商转账列表
     */
    public function carryretaillist($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('order_sn','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->with('retail')->where('pay','1')->where('judge','0')->where('good_id','neq','-1')->limit($limit)->where('order_status',2)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
}
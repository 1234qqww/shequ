<?php


namespace app\api\controller;
include_once 'KdApiSearchDemo.php';



use app\api\model\Ordergood;
use think\Config;
use think\Db;
use think\Request;

class Order extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->group=new Group();
        $this->ordergood=new Ordergood();
    }


    public function order_index()
    {
        $param = $this->request->param();

        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }



        if($param['prom_type']==2){
            if($param['group_id']=='undefined'){
                $groups=$this->group->groupshop($param['goods_id']);
                if($groups->regiment==0){
                    return json(array('code' => 2, 'msg' => '团购商品已下架'));
                }
            }
            $group=$this->group->shopnums($param['goods_id']);
            if($param['group_id']!='undefined'){
                foreach($group as $k=>$val){
                    if($val['user_id']==$param['userid']){
                        return json(['code'=>2,'msg'=>'您已参见该团购','data'=>'']);
                    }
                }
            }
            $order= model('order')->grouporders($param['goods_id'], $param['userid'], $param['num'], $param['skuid'],2,$param['group_id']);
            $groupshop=$this->group->groupshop($param['goods_id']);
            /**
             * 支付完成后把订单改未待发货
             */
            if(count($group)==$groupshop['num']){
                foreach ($groupshop as $k=>$val){
                    $this->ordergood->deliver($val->id);
                }
            }
        }else{
            $order= model('order')->orders($param['goods_id'], $param['userid'], $param['num'], $param['skuid']);
        }
        return json(array('code'=>1,'msg'=>'成功','data'=>$order));
    }
    //直接购买
    public function order_indexs()
    {
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $order=model('order')->order_All($param['cartsid'],$param['userid']);
        return json(array('code'=>1,'msg'=>'成功','data'=>$order));
    }


    public function order_update(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        if(is_array($param['order_id'])){
            foreach ($param['order_id'] as $k=>$v){
              Db::name('order')->where(['id'=>$v])->update(['user_address'=>$param['user_address']]);
            }
        }else{
              Db::name('order')->where(['id'=>$param['order_id']])->update(['user_address'=>$param['user_address']]);
        }

        return json(array('code'=>1,'msg'=>'成功'));
    }


    public function order_status(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $where['user_id']=$param['userid'];
        if($param['status']==1){
           $where['order_status']=0;            //待付款   订单状态待付款  支付状态未支付 发货状态未发货
            $where['pay_status']=0;
            $where['shipping_status']=0;
        }elseif ($param['status']==2){
           $where['order_status']=1;              //已付款待发货   订单状态待发货 支付状态已支付 发货状态未发货
           $where['pay_status']=1;
            $where['shipping_status']=0;
        }elseif($param['status']==3){
            $where['pay_status']=1;             //已发货   支付状态已支付 发货状态已发货
            $where['shipping_status']=1;
        }elseif ($param['status']==4){
            $where['order_status']=2;            //已完成    订单状态已完成 支付状态已支付
            $where['pay_status']=1;
        }elseif($param['status']==5){
            $where['order_status']=array('in','3,4');;            //退款/售后   订单状态售后
        }
        $order=model('order')->order_status($where);
        return json(array('code'=>1,'msg'=>'成功','data'=>$order));
    }

    public function order_wuliu(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
         $order_wuliu=Db::name('order_wuliu')->where(['order_id'=>$param['id']])->find();
         $order=Db::name('order')->where(['id'=>$param['id']])->find();

        if($order['good_id'] != -1) {
            $good = model('good')->getFind('id,pic',['id' => $order['good_id']['good_id']]);
            $good['pic'] = url_imgs($good['pic']);
        }else {
            $base = Config::get('base_config');;
            $good['pic'] = url_imgs($base['imgs']);
        }
        $OrderTraces=getOrderTracesByJson($order_wuliu['shipper_code'],$order_wuliu['wuliu_order']);
        $OrderTraces=json_decode($OrderTraces,true);
        return json(array('code'=>1,'msg'=>'成功','data'=>['order_wuliu'=>$order_wuliu,'good'=>$good['pic'],'traces'=>$OrderTraces]));

    }


    public function order_details(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }

        $order=model('order')->order_details($param['order_id']);
        return json(array('code' => 1, 'msg' => '查询成功','data'=>$order));

    }

    public function order_del(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $id=$param['order_id'];
        $order=Db::name('order')->where(['id'=>$id])->delete();
        $order_goods=Db::name('order_goods')->where(['order_id'=>$id])->delete();
        if(!$order || !$order_goods){
            return json(array('code' => 0, 'msg' => '取消失败'));
        }
        return json(array('code' => 1, 'msg' => '取消成功'));
    }
    public function order_refund_index(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $order=model('order')->order_refund_index($param['order_id']);

        return json(array('code' => 1, 'msg' => '成功','data'=>$order));
    }

    public function order_refund(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }

       $order=Db::name('order')->where(['id'=>$param['order_id']])->find();

       if($order['order_status']==3){
           return json(array('code' => 0, 'msg' => '请勿重复提交，请耐心等待平台审核'));
       }
        if($order['order_status']==4){
            return json(array('code' => 0, 'msg' => '该订单已退款'));
        }
        if($order['order_status']==5){
            return json(array('code' => 0, 'msg' => '该订单已失效'));
        }

        $arr=array(
            'order_id'=>$param['order_id'],
            'cause_name'=>$param['cause_name'],
            'cargo_name'=>$param['cargo_name'],
            'order_amount'=>$param['order_amount'],
             'add_time'=>date('Y-m-d H:i:s')
        );
        $refund_order=Db::name('refund_order')->insert($arr);
        Db::name('order')->where(['id'=>$param['order_id']])->update(['order_status'=>3]);
        if(!$refund_order){
            return json(array('code' => 0, 'msg' => '申请退款失败'));
        }
           return json(array('code' => 1, 'msg' => '申请退款成功'));

    }




}
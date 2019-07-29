<?php


namespace app\api\controller;



use think\Config;
use think\Db;

class Order extends Base
{
    //直接购买
    public function order_index()
    {
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $order= model('order')->orders($param['goods_id'], $param['userid'], $param['num'], $param['skuid']);
        return json(array('code'=>1,'msg'=>'成功','data'=>$order));
    }
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
            $where['order_status']=3;            //退款/售后   订单状态售后
        }
        $order=model('order')->order_status($where);

        return json(array('code'=>1,'msg'=>'成功','data'=>$order));

    }

}
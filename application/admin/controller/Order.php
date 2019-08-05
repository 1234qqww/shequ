<?php


namespace app\admin\controller;


use think\Db;
use think\Request;

class Order extends Base
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $admin=session('admin');
        if($admin['role_id']!=1){
            $this->good_id=session('good');
        }else{
            $this->good_id=-1;        //超级管理员添加商品商户id为-1
        }

    }
    //订单状态待收货
    public function order_wait(){
        if(request()->isAjax()){
            $data = input();
            $where['good_id']=$this->good_id;
            $where['order_status']=1;
            $where['pay_status']=1;
            $where['shipping_status']=1;


            if (isset($data['order_sn']) && !$data['order_sn'] == '') {
                $where['order_sn'] = array('like', '%' . $data['order_sn'] . '%');
            }
            if (isset($data['consignee']) && !$data['consignee'] == '') {
                $where['consignee'] = $data['consignee'];
            }
            if (isset($data['add_time']) && $data['add_time'] != '') {
                $times = explode(' - ', $data['add_time']);
                $where['add_time'] = array('between', array($times[0] . ' 00:00:00', $times[1] . " 23:59:59"));

            }
            $order=model('order')->order_where($where);
            return $order;

        }
        return $this->fetch();
    }


    //订单状态待付款
    public function order_wait_payment(){

        if(request()->isAjax()){
            $data = input();
            $where['good_id']=$this->good_id;
            $where['order_status']=0;
            $where['pay_status']=0;
            if (isset($data['order_sn']) && !$data['order_sn'] == '') {
                $where['order_sn'] = array('like', '%' . $data['order_sn'] . '%');
            }
            if (isset($data['consignee']) && !$data['consignee'] == '') {
                $where['consignee'] = $data['consignee'];
            }
            if (isset($data['add_time']) && $data['add_time'] != '') {
                $times = explode(' - ', $data['add_time']);
                $where['add_time'] = array('between', array($times[0] . ' 00:00:00', $times[1] . " 23:59:59"));

            }
            $order=model('order')->order_where($where);
            return $order;
        }
        return $this->fetch();
    }


    //订单状态已完成
    public function order_order_end(){
        if(request()->isAjax()){
            $data = input();
            $where['good_id']=$this->good_id;
            $where['order_status']=2;
            $where['pay_status']=1;
            if (isset($data['order_sn']) && !$data['order_sn'] == '') {
                $where['order_sn'] = array('like', '%' . $data['order_sn'] . '%');
            }
            if (isset($data['consignee']) && !$data['consignee'] == '') {
                $where['consignee'] = $data['consignee'];
            }
            if (isset($data['add_time']) && $data['add_time'] != '') {
                $times = explode(' - ', $data['add_time']);
                $where['add_time'] = array('between', array($times[0] . ' 00:00:00', $times[1] . " 23:59:59"));

            }
            $order=model('order')->order_where($where);
            return $order;

        }
        return $this->fetch();
    }


    //订单状态 申请退款
    public function order_order_close(){
        if(request()->isAjax()){
            $data = input();
            $where=array();
            if (isset($data['order_id']) && !$data['order_id'] == '') {
                $where['order_id'] = $data['order_id'];
            }
            if (isset($data['state']) && !$data['state'] == '') {
                $where['state'] = $data['state'];
            }
            if (isset($data['add_time']) && $data['add_time'] != '') {
                $times = explode(' - ', $data['add_time']);
                $where['add_time'] = array('between', array($times[0] . ' 00:00:00', $times[1] . " 23:59:59"));

            }
            return  Db::name('refund_order')->where($where)->order('state asc add_time desc')->paginate(15);
        }
        return $this->fetch();
    }
    //全部订单
    public function order_list(){
        if(request()->isAjax()){
            $data = input();
            $where['good_id']=$this->good_id;
            $where['order_status']=array('neq',5);

            if (isset($data['order_sn']) && !$data['order_sn'] == '') {
                $where['order_sn'] = array('like', '%' . $data['order_sn'] . '%');
            }
            if (isset($data['consignee']) && !$data['consignee'] == '') {
                $where['consignee'] = $data['consignee'];
            }
            if (isset($data['add_time']) && $data['add_time'] != '') {
                $times = explode(' - ', $data['add_time']);
                $where['add_time'] = array('between', array($times[0] . ' 00:00:00', $times[1] . " 23:59:59"));

            }
            $order=model('order')->order_where($where);
            return $order;
        }
       return $this->fetch();
    }


    //订单查询
    public function edit_order(){
        if(request()->isAjax()){
            return 111;
        }
        $arr=model('order')->edit_order(input('id'));
        $btn=$this->getOrderButton($arr['order']);
        $this->assign([
            'order'=>$arr['order'],
            'goods'=>$arr['goods'],
             'wuliu'=>$arr['wuliu'],
             'btn'=>$btn
        ]);

        return view();
    }


    public function order_action(){
       $param=$this->request->param();

       $hand=$this->orderProcessHandle($param['order_id'],$param['key']);
       if(!$hand){
           return json(array('code'=>0));
       }
        return json(array('code'=>1));

    }


     function getOrderButton($order){
        $os = $order['order_status'];//订单状态
        $ss = $order['shipping_status'];//发货状态
        $ps = $order['pay_status'];//支付状态
        $btn = array();

        if($ps== 1) {
            if($os==1 && $ss==0 ){

                $btn['delivery'] = '去发货';
            }elseif ($ss == 1 && $os == 1 ){
                $btn['delivery_confirm'] = '确认收货';
            }elseif ($os == 3 ){
                $btn['refund'] = '退款';
            }elseif ($os == 4 ){
                $btn['refunded'] = '已退款';
            }
        }
        if($os != 5){
            $btn['invalid'] = '无效订单';
        }
        return $btn;
    }

    public function orderProcessHandle($order_id,$act){

        $updata = array();
        switch ($act){
            case 'invalid': //作废订单
                $updata['order_status'] = 5;
                break;
            case 'delivery_confirm': //确认收货
                $updata['shipping_status'] =2;
                $updata['order_status'] = 3;
                break;
            case 'delivery'://去发货
                $updata['shipping_status'] =1;
                break;
            case 'refund'://退款

                return true;
            default:
                return true;
        }
        return Db::name('order')->where(['id'=>$order_id])->update($updata);//改变订单状态
    }
    public function order_wuliu(){
        if(request()->isAjax()){
          $param=$this->request->param();

          $wuliu=Db::name('wuliu')->where(['id'=>$param['wuliu_id']])->find();
          $arr=array(
              'order_id'=>$param['order_id'],
              'wuliu_name'=>$wuliu['wuliu_name'],
              'shipper_code'=>$wuliu['shipper_code'],
              'wuliu_order'=>$param['wuliu_order']
          );
           $order_wuliu=Db::name('order_wuliu')->insert($arr);

           if(!$order_wuliu){
               return json(array('code'=>0,'msg'=>'失败'));
           }
            return json(array('code'=>1,'msg'=>'成功'));
        }

        $wuliu=Db::name('wuliu')->select();
        $this->assign([
            'order_id'=>input('id'),
            'wuliu'=>$wuliu
        ]);
        return $this->fetch();

    }

    public function order_wuliu_edit(){
        if(request()->isAjax()){
            $order_wuliu=Db::name('order_wuliu')->where(['id'=>input('id')])->update(input());

            if(!$order_wuliu){
                return json(array('code'=>0,'msg'=>'失败'));
            }
            return json(array('code'=>1,'msg'=>'成功'));
        }
        $wuliu=Db::name('order_wuliu')->where(['id'=>input('id')])->find();

        $this->assign([
            'wuliu'=>$wuliu
        ]);
        return $this->fetch();
    }





}
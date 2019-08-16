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
        }elseif($param['prom_type']==1){
         $good_seckill=model('good_seckill')->seckill($param['goods_id'],$param['userid']);

         if($good_seckill['code']!=1){
             return json($good_seckill);
         }
         $order=model('order')->order_seckill($param['goods_id'], $param['userid'], $param['num'], $param['skuid'],$good_seckill['data']);

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
        if(isset($param['retail_id'])){
            $where['retail_id']=$param['retail_id'];
        }
        $where['user_id']=$param['userid'];
        $where['order_prom_type']=$param['prom_type'];
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
<<<<<<< HEAD
        foreach($order as $ks=>$val){
            if($val['order_status']==0 && $val['order_prom_type']==2){
                    $orders=$this->order->hand($val['order_sn']);
                    $ordergood= $this->ordergood->regiment($val['id']);
                    $group=$this->group->groupshop($ordergood->goods_id);
                    if($group){
                        $ds=$group->num-count($orders)-1;
                        $order[$ks]['times']=round((time()+$group->times*3600*24-strtotime($val['add_time']))/3600);
                        if( $order[$ks]['times']<0){
                            $order[$ks]['times']=0;
                        }else{
                            $order[$ks]['num']=$ds;
                        }
                    }
            }
        }
=======
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
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
    /**
     * 拼团订单
     */
    public function order_group(){
        $param = $this->request->param();
        unset($param['token']);
        if (!$param['userid']) {
            return json(array('code' => 0, 'msg' => '非法操作'));
        }
        $order=model('order')->order_details($param['order_id']);
        $new=new \app\api\model\Order();
        $groupuser=$this->order->groupuser($order['group_id']);
//        $this->order->
        return json(array('code' => 1, 'msg' => '查询成功','data'=>$order));

    }

        public function order_sub(){
            $param = $this->request->param();
            unset($param['token']);
            if (!$param['userid']) {
                return json(array('code' => 0, 'msg' => '非法操作'));
            }
            $order=Db::name('order')->where(['id'=>input()['order_id']])->find();
            if($order['order_status']==1 && $order['pay_status']==1){
                return json(array('code' => 0, 'msg' => '订单已支付，请勿重复支付'));

            }
            $user=model('user')->GetUser(['id'=>$param['userid']],'id,user_money,openid');
            if($order['order_prom_type']==1){
                $good_seckill=model('good_seckill')->order_goods_all($order['id']);
                $seckill=model('good_seckill')->seckill($good_seckill['goods_id'],$user['id']);
                if($seckill['code']!=1){
                    return json($seckill);
                }
                if($seckill['data']['purchase']<$good_seckill['goods_num']){
                    return json(array('code'=>0,'msg'=>'商品数量库存不足，请选择其他商品购买'));
                }
                $res=\model('good_seckill')->get_list($seckill['data']['id'],input('userid'));
                if($res){
                    if($good_seckill['goods_num']>$seckill['data']['purchase']-$res['purchase']){
                        return ['code'=>0,'msg'=>'抱歉该商品限购'.$seckill['purchase'].'个，你已购'.$res['purchase'].'个'];
                    }
                }
            }else{
                $order_goods=\model('order_good')->order_goods_all($order['id']);   //查询订单下所有商品
                foreach ($order_goods as $k=>$v){
                    if($v['store_count']<$v['goods_num']){
                        return json(array('code'=>0,'msg'=>'抱歉，你选择的商品'.$v['goods_name'].'库存不足，请重新下单'));
                    }
                }
            }
            switch (input('pay_id')){
                case 1:                          //微信支付
                    $amountmoney=$order['order_amount'];
                    $ordernumber=rand(111111,999999).date('YmdHis').rand(111111,999999);
                    $wx=Config::get('qudao');
                    $url=Config::get('host');
                    $Retail=new Retail();
                    $attach=json_encode([
                        'user_id'=>input('userid'),
                        'pay_id'=>input('pay_id'),
                        'order_id'=>input('order_id')
                    ]);

                    $data=$Retail->initiatingPayment($amountmoney,$ordernumber,$user['openid'],$wx['appid'],$wx['mchid'],$wx['secret'],$url['url'].'/api/order/notify','畅想社区商城-消费',$attach);
                     return  json(array('code' =>1000,'data'=>$data));
                    break;
                case 2:                          //余额支付
                 if($user['user_money']<$order['order_amount']){
                     return json(array('code' => 0, 'msg' => '余额不足，请重新选择支付方式'));
                 }
                 $user=model('user')->order_sub($order,input('pay_id'),input('userid'));
                 if($user['code']!=1){
                     return json($user);
                 }
                 $state=model('order')->order_sub($order,input('pay_id'));
                if(!$state){
                    return json(array('code' => 0, 'msg' => '支付失败'));
                }
                    return json(array('code' => 1, 'msg' => '支付成功'));
                 break;


            }


        }


//处理微信支付回调
    public function notify(){

        $testxml  = file_get_contents("php://input");

        $arr=$this->xmlToArray($testxml);
        if($arr){
            //如果成功返回了
            $out_trade_no = $arr['out_trade_no'];
            if($arr['return_code'] == 'SUCCESS' && $arr['result_code'] == 'SUCCESS'){
                file_put_contents('log11111.log',$arr['return_code']);
              $attach=json_decode($arr['attach'],true);
              $order=Db::name('order')->where(['id'=>$attach['order_id']])->find();
               model('user')->order_sub($order,$attach['pay_id'],$attach['user_id']);
               model('order')->order_sub($order,$attach['pay_id']);


            }
        }

    }


    //将XML转为array
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }






    }
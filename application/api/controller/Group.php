<?php
namespace app\api\controller;

use app\api\controller\Queue;
use app\api\model\GroupModel;
use app\api\model\GroupregimentModel;
use app\api\model\RetailModel;
use app\api\model\SelfshopModel;
use app\common\model\Txapi;
use think\Request;
use app\api\model\UserModel;
use app\api\model\Goods;
use app\api\model\Ordergood;
use app\api\model\Order;


class Group extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->user=new UserModel();
        $this->goods=new Goods();
        $this->group=new GroupModel();
        $this->subject= new Subject();
        $this->ordergood= new Ordergood();
        $this->order= new Order();
        $this->retail= new Retail();
        $this->retailmodel= new RetailModel();
        $this->groupregiment= new GroupregimentModel();
        $this->selfshop= new SelfshopModel();
        $this->queue=new  Queue(10);
    }
    public function group(Request $request){
        $param=$request->param();
        $data=$this->group->lists($param);
        $dat=[];
        if(empty($param['retail_id'])){
            foreach($data as $k=>$val){
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$val['goods']['original_img'])){
                    $data[$k]['goods']['original_img']=$this->subject->nowUrl(). $val['goods']['original_img'];
                }
                    $goods=$this->goods->oneData($val->goods_id);
                    if($goods->prom_type==2){
                        $dat[]=$val;
                    }
            }
        }else{
            $ifs=$this->selfshop->ifs($param);
            $ids=json_decode($ifs->ids);
            foreach($ids as $k=>$val){
                $good=$this->goods->one($val);
                if($good){
                    $datas=$this->group->groupshop($val);
                    $dat[]=$datas;
                }
            }
        }
        return $dat?json(['code'=>0,'msg'=>'团购商品列表','data'=>$dat]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 通过商品查询拼团id 后端
     */
    public function  groupshop($goods_id){
        $data=$this->group->groupshop($goods_id);
        return $data;
    }
    /**
     * 通过商品查询拼团id 小程序
     */
    public function  groupshops($goods_id){
        $data=$this->group->groupshop($goods_id);
        return $data?json(['code'=>0,'msg'=>'团购商品详情','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 通过商品id来查询团购商品人数
     */
    public function shopnum(Request $request){
        $param=$request->param();
        $ordergood=$this->ordergood->order($param['goods_id']);
        $orders=[];
        $count=0;
        $s=0;
        foreach($ordergood as $k=>$val){
            $order=$this->order->grouporder($val->order_id);
            if($order){
                $orders[$s]=$order->toArray();
                $orders[$s]['data'][]=$order;
                $grouporder=$this->order->groupuser($order->order_sn);

                foreach($grouporder as $k=>$val){
                    $orders[$s]['data'][]=$val;
                }
                $orders[$s]['count']=count($orders[$s]['data']);
                $count+= $orders[$s]['count'];
                $s++;

            }
        }
        return $orders?json(['code'=>0,'msg'=>'团购人数','data'=>$orders,'count'=>$count]):json(['code'=>1,'msg'=>'无数据','data'=>$orders]);
    }
    public function shopnums($goods_id){
        $ordergood=$this->ordergood->order($goods_id);
        $orders=[];
        $count=0;
        $s=0;
        foreach($ordergood as $k=>$val){
            $order=$this->order->grouporder($val->order_id);

            if($order){
                $orders[$s]=$order->toArray();
                $orders[$s]['data'][]=$order;
                $grouporder=$this->order->groupuser($order->order_sn);
                foreach($grouporder as $k=>$val){
                    $orders[$s]['data'][]=$val;
                }
                $orders[$s]['count']=count($orders[$s]['data']);
                $count+= $orders[$s]['count'];
                $s++;

            }
        }
        return $orders;
    }
    /**
     * @param int $length
     * @return string
     * 随机生成字符串
     */
    function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    /**
     * 开团 或 解散团并退款
     */
    public function regiment(){
        $ordergood=$this->order->regiment();
        $data=[];
        foreach ($ordergood as $k=>$val){
            $ordergoods=$this->ordergood->regiment($val->id);
            $group=$this->group->groupshop($ordergoods->goods_id);
            $datas= date('Y-m-d h:i:s',strtotime($val->add_time)+$group->times*3600*24);
            if($datas>date('Y-m-d h:i:s',time())){
                $data[]=$val;
                $hand=$this->order->hand($val->order_sn);
                $txapi=new Txapi();
                $nonce= $this->createNonceStr();
                $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
                $strs=substr(str_shuffle($str),mt_rand(0,strlen($str)-11),1);
                $ordernumbers='H'.date('ymdHis') .$strs;
                //退款
                @$refund=$this->retail->refund($txapi->appid,$txapi->mchid,$nonce,$val->order_sn,$ordernumbers,$val->total_amount,$txapi->secret,$txapi->autograph,$txapi->templatecode);
                //团购失败后添加退款记录
                $data=array(
                    'order_sn'=>$val->order_sn,
                    'user_id'=>$val->user_id,
                    'money'=>$val->total_amount
                );
                @$this->groupregiment->add($data);
                @$this->order->dissolution($val->id);
                //团购成员进行退款等操作
                foreach ($hand as $key=>$value){
                    $this->queue->enQueue($value);
                    $ss=$this->queue->deQueue();
                    echo "<pre>";
                    print_r($ss);
                    echo "</pre>";
                }

            }

        }


    }

}
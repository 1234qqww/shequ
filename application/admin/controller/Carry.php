<?php
namespace app\admin\controller;

use app\admin\model\Advise;
use app\admin\model\BrokerModel;
use app\admin\model\Order;
use app\admin\model\RetailrecordModel;
use app\admin\model\Admin;
use app\admin\model\TopicModel;
use think\Request;
use think\Session;

class Carry extends Base
{
    private $order;
    private $broker;
    private $retailrecord;
    public function _initialize(){
        parent::_initialize();
        $this->order=new Order();
        $this->broker=new BrokerModel();
        $this->retailrecord=new RetailrecordModel();
    }
    public function carry(){
        return $this->fetch('index');
    }
    public function lists(Request $request){
        $param=$request->param();
        $data=$this->order->lists($param);
        $broker=$this->broker->onedata();
        foreach ($data['data'] as $k=>$val){
            $data['data'][$k]->moneys= $val->order_amount-floor(($val->order_amount*$broker->broker+$val->order_amount*$broker->percent)*100)/100;
            $data['data'][$k]->retail= floor(($val->order_amount*$broker->percent)*100)/100;
        }
        return $data['data']?['code'=>0,'msg'=>'完成订单','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }
    public function edit(Request $request,$id){
        $param=$request->param();
        $data=$this->order->carry($param,$id);
        $order= $this->order->oneData($id);
        $broker=$this->broker->onedata();
        $moenys=floor(($order->order_amount*$broker->percent)*100)/100;
        $dat=array(
            'order_id'=>$id,
            'moneys'=>$moenys,
        );
        @$this->retailrecord->add($dat);
        return $data?['code'=>0,'msg'=>'完成','data'=>'']:['code'=>1,'msg'=>'失败','data'=>''];
    }
    /**
     * 转账记录
     */
    public function carryrecord(){
        return $this->fetch('carryrecord');
    }
    /**
     * 转账列表
     */
    public function carrylists(Request $request){
        $param=$request->param();
        $data=$this->order->carrylist($param);
        return $data['data']?['code'=>0,'msg'=>'完成订单','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }
    /**
     * 给分销商转账
     */
    public function retailcord(){
        return $this->fetch('retailcord');
    }
    /**
     * 转账列表
     */
    public function retaillist(Request $request){
        $param=$request->param();
        $data=$this->order->retaillist($param);
        $broker=$this->broker->onedata();
        foreach ($data['data'] as $k=>$val){
            $data['data'][$k]->moneys= floor(($val->order_amount*$broker->percent)*100)/100;
        }
        return $data['data']?['code'=>0,'msg'=>'转账列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }
    /**
     * 给分销商转账记录
     */
    public function retailrecord(){
        return $this->fetch('retailrecord');
    }
    /**
     * 转账列表记录
     */
    public function retaillists(Request $request){
        $param=$request->param();
        $data=$this->order->retaillists($param);
        $broker=$this->broker->onedata();
        foreach ($data['data'] as $k=>$val){
            $data['data'][$k]->moneys= floor(($val->order_amount*$broker->percent)*100)/100;
        }
        return $data['data']?['code'=>0,'msg'=>'转账列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }
    /**
     * 商户给分销商转账
     */
    public function carryretail(){
        return $this->fetch('carryretail');
    }
    /**
     * 转账列表
     */
    public function  carryretaillist(Request $request){
        $param=$request->param();
        $data=$this->order->carryretaillist($param);
        $broker=$this->broker->onedata();
        foreach ($data['data'] as $k=>$val){
            $data['data'][$k]->moneys= floor(($val->order_amount*$broker->percent)*100)/100;
        }
        return $data['data']?['code'=>0,'msg'=>'转账列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }

    /**
     * 商户给分销商转账
     */
    public function retailedit(Request $request){
        $param=$request->param();
        $data= $this->retailrecord->add($param);
        return $data?['code'=>0,'msg'=>'完成','data'=>'']:['code'=>1,'msg'=>'失败','data'=>''];
    }
    /**
     * 商户给分销商转账记录
     */
    public function carryretailrecord(Request $request){
        return $this->fetch('carryretailrecord');
    }
    public function carryretailrecordlist(Request $request){
        $param=$request->param();
        $data=$this->retailrecord->carrylist($param);
        return $data['data']?['code'=>0,'msg'=>'转账列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>'','count'=>''];
    }


}
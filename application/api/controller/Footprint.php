<?php
namespace app\api\controller;
use app\api\model\CollectModel;
use app\api\model\FootprintModel;
use app\api\model\Goods;
use think\Request;

class Footprint extends Base
{
    private  $footprint;
    public function _initialize()
    {
       $this->footprint= new FootprintModel();
    }
    public function footprint(Request $request){
        $param=$request->param();
        $data=$this->footprint->iffootprint($param);
        return $data?json(['code'=>0,'msg'=>'浏览','data'=>$data]):json(['code'=>1,'msg'=>'未浏览','data'=>'']);
    }
    /**
     * 浏览商品
     */
    public function addfootprint(Request $request){
        $param=$request->param();
        $dat=$this->footprint->goods($param['goods_id']);
        if($dat){
            return $dat?json(['code'=>0,'msg'=>'已浏览','data'=>$dat]):json(['code'=>1,'msg'=>'未浏览','data'=>'']);
        }else{
            $data=$this->footprint->add($param);
            return $data?json(['code'=>0,'msg'=>'已浏览','data'=>$data]):json(['code'=>1,'msg'=>'未浏览','data'=>'']);
        }
    }
    /**
     * 取消浏览
     */
    public function delCollect(Request $request){
        $param=$request->param();
        $data=$this->footprint->del($param);
        return $data?json(['code'=>0,'msg'=>'取消收藏','data'=>$data]):json(['code'=>1,'msg'=>'操作失败','data'=>'']);
    }
    /**
     * 查看某用户所有浏览过的商品
     */
    public function userCollect(Request $request){
        $param=$request->param();
        $data=$this->footprint->selUser($param['user_id']);
        return $data?json(['code'=>0,'msg'=>'收藏的商品','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 用户所有收藏商品的详情
     */
    public function usershop(Request $request){
        $param=$request->param();
        $param=json_decode($param['goods_id'],true);
        $data=[];
        foreach($param as $k=>$val){
            $data[]=$this->goods->oneData($val['goods_id']);
        }
        return $data?json(['code'=>0,'msg'=>'商品','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }


}
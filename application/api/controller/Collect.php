<?php
namespace app\api\controller;
use app\api\model\CollectModel;
use app\api\model\Goods;
use think\Request;

class Collect extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->collect=new CollectModel();
        $this->goods=new Goods();
    }
    public function collect(Request $request){
        $param=$request->param();
        $data=$this->collect->ifcollect($param);
        return $data?json(['code'=>0,'msg'=>'收藏','data'=>$data]):json(['code'=>1,'msg'=>'未收藏','data'=>'']);
    }
    /**
     * 收藏商品
     */
    public function addCollect(Request $request){
        $param=$request->param();
        $data=$this->collect->add($param);
        return $data?json(['code'=>0,'msg'=>'已收藏','data'=>$data]):json(['code'=>1,'msg'=>'未收藏','data'=>'']);
    }
    /**
     * 取消收藏
     */
    public function delCollect(Request $request){
        $param=$request->param();
        $data=$this->collect->del($param);
        return $data?json(['code'=>0,'msg'=>'取消收藏','data'=>$data]):json(['code'=>1,'msg'=>'操作失败','data'=>'']);
    }
    /**
     * 查看某用户所有收藏的商品
     */
    public function userCollect(Request $request){
        $param=$request->param();
        $data=$this->collect->selUser($param['user_id']);
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
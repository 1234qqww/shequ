<?php
namespace app\api\controller;

use app\api\model\GroupModel;
use think\Request;
use app\api\model\UserModel;
use app\api\model\Goods;


class Group extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->user=new UserModel();
        $this->goods=new Goods();
        $this->group=new GroupModel();
        $this->subject= new Subject();
    }
    public function group(){
        $data=$this->group->lists();
        foreach($data as $k=>$val){
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$val['goods']['original_img'])){
                $data[$k]['goods']['original_img']=$this->subject->nowUrl(). $val['goods']['original_img'];
            }
        }
        return $data?json(['code'=>0,'msg'=>'团购商品列表','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 通过商品查询拼团id
     */
    public function  groupshop($goods_id){
        $data=$this->group->groupshop($goods_id);
        return $data?json(['code'=>0,'msg'=>'团购商品详情','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }

}
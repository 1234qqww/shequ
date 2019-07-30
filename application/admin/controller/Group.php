<?php
namespace app\admin\controller;

use app\admin\model\GroupModel;
use app\common\model\Txapi;
use think\Controller;
use think\Request;
use app\admin\model\RetailModel;
use app\admin\model\BrokerModel;
use app\admin\model\UserModel;
use app\admin\model\Goods;

class Group extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->retail=new RetailModel();
        $this->broker=new BrokerModel();
        $this->user=new UserModel();
        $this->goods=new Goods();
        $this->group=new GroupModel();
    }
    public function group(){
        return $this->fetch('index');
    }
    /**
     * 拼团商品列表
     */
    public function lists(Request $request){
        $param=$request->param();
        $data=$this->group->lists($param);
        return $data?['code'=>0,'msg'=>'拼团列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','',];
    }
    /**
     * 添加拼团商品
     */
    public function add_group(){
        return $this->fetch('add_group');
    }
    /**
     * 商品列表
     */
    public function shopgood(Request $request){
        $param=$request->param();
        if(isset($param['goods_id'])){
            $this->assign('goods_id',$param['goods_id']);
        }else{
            $this->assign('goods_id','');
        }
        return $this->fetch('shopgood');
    }
    public function shopgoodlist(Request $request){
        $param=$request->param();
        $data=$this->goods->groupshops($param);
        foreach($data['data'] as $k=>$val){
            if($val->id==$param['goods_id']){
                $data['data'][$k]['LAY_CHECKED']=true;
            }
        }
        return $data['count']!=0?['code'=>0,'msg'=>'全部商品','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 添加拼团商品
     */
    public function add(Request $request){
        $param=$request->param();
        $this->goods->eidtgroup($param['goods_id']);
        $data=$this->group->add($param);
        return $data?['code'=>0,'msg'=>'添加成功','data'=>$data]:['code'=>1,'msg'=>'添加失败','data'=>''];
    }
    /**
     * 修改拼团商品
     */
    public function update_group($id){
        $group=$this->group->oneData($id);
        $this->assign('group',$group);
        return $this->fetch('update_group');
    }
    public function group_edit(Request $request,$id){
        $param=$request->param();
        $param['id']=$id;
        $group=$this->group->oneData($id);
        $this->goods->shopgroup($group->goods_id);
        $this->goods->eidtgroup($param['goods_id']);
        $data=$this->group->edit($param);
        return $data?['code'=>0,'msg'=>'修改成功','data'=>$data]:['code'=>1,'msg'=>'修改失败','data'=>''];
    }
    /**
     * 删除商品
     */
    public function group_del($id){
        $data=$this->group->del($id);
        return $data?['code'=>0,'msg'=>'删除成功','data'=>$data]:['code'=>1,'msg'=>'删除失败','data'=>''];
    }
}
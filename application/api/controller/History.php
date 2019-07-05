<?php


namespace app\api\controller;


use think\Controller;
use think\Db;

class History extends Controller
{
    //查询历史记录
    public function history(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }

        $historical=Db::name('historical')->where(['userid'=>$param['userid'],'state'=>$param['state']])->field('merid,state')->order('atime desc')->select();
        $list=array();
        foreach ($historical as $k=>$v){
          $list[$k]=$this->getList($v['merid']);
        }
        return  json(array('code'=>1,'msg'=>'操作成功','data'=>$list));
    }

    public function getList($id){
        $result=Db::name('merchant')->where(['id'=>$id])->field('mername,merportrait,prov,city,area,address,lng,lat,mobile,setout,arrive,id')->find();
        return $result;
    }


    //添加收藏
    public function addcoll(){
        $param=$this->request->param();
        $arr['userid']=$param['userid'];
        $arr['merid']=$param['id'];
        $arr['state']=$param['state'];         //商户收藏
        $arr['atime']=date('Y-m-d H:i:s');
        $collection=Db::name('collection')->insert($arr);
        if ($collection){
            return  json(array('code'=>1,'msg'=>'操作成功','data'=>$collection));
        }
    }

    //取关
    public function delcoll(){
        $param=$this->request->param();
        $row=Db::name('collection')->where(['userid'=>$param['userid'],'merid'=>$param['id'],'state'=>$param['state']])->delete();
        if($row){
            return  json(array('code'=>1,'msg'=>'取关成功'));
        }
    }




    //收藏列表
    public function shouchang(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $historical=Db::name('collection')->where(['userid'=>$param['userid'],'state'=>$param['state']])->field('merid,state')->order('atime desc')->select();
        $list=array();
        foreach ($historical as $k=>$v){
            $list[$k]=$this->getList($v['merid']);
        }
        return  json(array('code'=>1,'msg'=>'操作成功','data'=>$list));
    }





}
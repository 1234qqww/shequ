<?php


namespace app\api\controller;


use think\Config;
use think\Db;

class Index extends Base
{

    /**
     * 商城首页
     */
    public function  index(){
        $param=$this->request->param();
        unset($param['token']);
        $slide='';
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }

        $good_category=model('good_category')->selectTuiJianAll();
        if(isset($param['position'])){
            $slide=model('slide')->selectPosition($param['position']);
        }

        if($param['category_id']!=0){
            $goods=model('goods')->selectAllWhere($param['category_id'],$param['page']);
        }else{
            $where['store_count']= array('neq',0);
            $where['state']= 1;
            $where['is_show']=1;
            $goods=model('goods')->selectAll($where,$param['page']);
        }

        $arr=array('good_category'=>$good_category,'slide'=>$slide,'goods'=>$goods);

        return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));
    }
    //商品详情
    public function goods(){
        $param=$this->request->param();
        $type=$param['type'];
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $goods=Db::name('goods')->where(['id'=>$param['id']])->find();
        $goods_img=Db::name('goods_img')->where(['goods_id'=>$param['id']])->select();
        $url=Config::get('host');
        foreach ($goods_img as $k=>$v){
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$v['path'])){
                $goods_img[$k]['path']=$url['url'].$v['path'];
            }
        }
        if($type==0){
            $arr=array('goods_img'=>$goods_img,'goods'=>$goods);
            return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));
        }
    }



}
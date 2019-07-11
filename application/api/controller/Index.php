<?php


namespace app\api\controller;


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



}
<?php


namespace app\api\controller;


use think\Db;

class Commodity extends Base
{
    public function index(){
        $param=$this->request->param();
        unset($param['token']);
        $where=array('is_show'=>1,'parent_id'=>0);
        $category=Db::name('good_category')->where($where)->order('sort_order asc')->select();
        foreach ($category as $k=>$v){
            $category[$k]['categorys']=$this->selectCategory($v['id']);
        }
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$category));
    }

    function selectCategory($id){
        $categorys=Db::name('good_category')->where(['parent_id'=>$id,'is_show'=>1])->select();
        foreach ($categorys as $k=>$v){
                $categorys[$k]['childs']=Db::name('good_category')->where(['parent_id'=>$v['id'],'is_show'=>1])->select();
        }
        return $categorys;


    }



}
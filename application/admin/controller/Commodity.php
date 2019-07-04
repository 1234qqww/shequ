<?php


namespace app\admin\controller;


use think\Db;

class Commodity extends Base
{
    //销售中的商品
    public function commodity(){
        if(request()->isAjax()){
            $get=input();
            $where=array('store_count'=>0,'state'=>1);
            if(isset($get['good_name']) && $get['good_name']!=''){
                $where['good_name']=array('like','%'.$get['good_name'].'%');
            }
            return model('goods')->goods($where);
        }
        return $this->fetch();

    }
    //添加商品
    public function add_commodity(){
        if(request()->isAjax()){

           dump(input());die();

        }
        $cat_list = Db::name('good_category')->where("parent_id = 0")->select();   //获取一级菜单
        $this->assign([
            'cat_list' =>$cat_list
        ]);

        return $this->fetch();
    }




    //回收站
    public function commodity_del(){


    }

    //已售罄
    public function commodity_out(){


    }

    //商品分类
    public function commodity_category(){
        $cat_list=model('good_category')->goods_cat_list();
        $this->assign('cat_list',$cat_list);
        return $this->fetch();
    }

    //添加商品属性

    public function category_add(){
        if(request()->isAjax()){
            $param=$this->request->param();


            if($param['sort_order']<0){
                return json(array('code'=>0,'msg'=>'排序数字不能小于0'));
            }
            if(strpos($param['image'],'base64') !== false){
                $param['image']=base64toimg($param['image']);
            }
            if(isset($param['is_show'])){
                $param['is_show']=1;
            }else{
                $param['is_show']=0;
            }
            if(isset($param['is_tuijian'])){
                $param['is_tuijian']=1;
            }else{
                $param['is_tuijian']=0;
            }

            if($param['parent_id_1']==0){
                $param['level']=1;                     //顶级分类
                $param['parent_id']=$param['parent_id_1'];
                unset($param['parent_id_1']);
                unset($param['parent_id_2']);
                $good_category=Db::name('good_category')->insertGetId($param);
                $path= $param['parent_id'].'-'.$good_category;

               $row=Db::name('good_category')->where(['id'=>$good_category])->data(['parent_id_path'=>$path])->update();
                if(!$row){
                    return json(array('code'=>0,'msg'=>'添加失败'));
                }


                return json(array('code'=>1,'msg'=>'添加成功'));
            }
            if($param['parent_id_1']!=0 && $param['parent_id_2']==''){
                $param['level']=2;
                $param['parent_id']=$param['parent_id_1'];
                unset($param['parent_id_1']);
                unset($param['parent_id_2']);
                $good_category=Db::name('good_category')->insertGetId($param);
                $find=Db::name('good_category')->where(['id'=>$param['parent_id']])->find();
                $path= $find['parent_id_path'].'-'.$good_category;
                $row=Db::name('good_category')->where(['id'=>$good_category])->data(['parent_id_path'=>$path])->update();
                if(!$row){
                    return json(array('code'=>0,'msg'=>'添加失败'));
                }
                return json(array('code'=>1,'msg'=>'添加成功'));

            }

            if($param['parent_id_1']!=0 && $param['parent_id_2']!=''){
                $param['level']=3;
                $param['parent_id']=$param['parent_id_2'];
                unset($param['parent_id_1']);
                unset($param['parent_id_2']);
                $good_category=Db::name('good_category')->insertGetId($param);
                $find=Db::name('good_category')->where(['id'=>$param['parent_id']])->find();
                $path= $find['parent_id_path'].'-'.$good_category;
                $row=Db::name('good_category')->where(['id'=>$good_category])->data(['parent_id_path'=>$path])->update();
                if(!$row){
                    return json(array('code'=>0,'msg'=>'添加失败'));
                }
                return json(array('code'=>1,'msg'=>'添加成功'));
            }
        }


        $cat_list = Db::name('good_category')->where("parent_id = 0")->select();   //获取一级菜单

        $this->assign([
           'cat_list' =>$cat_list
        ]);


        return $this->fetch();
    }

    //联动菜单下级获取
    public function get_category(){
            $good_category=Db::name('good_category')->where(input())->select();
             return json(array('code'=>1,'msg'=>'查询成功','data'=>$good_category));


    }



    //修改当前商品属性

    public function category_edit(){
        if (request()->isAjax()){
            $param=$this->request->param();
            if($param['sort_order']<0){
                return json(array('code'=>0,'msg'=>'排序数字不能小于0'));
            }
            if(strpos($param['image'],'base64') !== false){
                $param['image']=base64toimg($param['image']);
            }
            if(isset($data['is_show'])){
                $param['is_show']=1;
            }else{
                $param['is_show']=0;
            }
            if(isset($param['is_tuijian'])){
                $param['is_tuijian']=1;
            }else{
                $param['is_tuijian']=0;
            }
            $res=Db::name('good_category')->where(['id'=>$param['id']])->data($param)->update();

            if(!$res){
                return json(array('code'=>0,'msg'=>'修改失败'));
            }

            return json(array('code'=>1,'msg'=>'修改成功'));

        }
       $data= Db::name('good_category')->where(input())->find();
       $this->assign([
         'data'=>$data
       ]);
       return $this->fetch();
    }


    //删除分类
    public function category_del(){
        $param=$this->request->param();
        $parent=Db::name('good_category')->where(['parent_id'=>$param['id']])->select();
        if($parent){
            return json(array('code'=>0,'msg'=>'该分类下存在下级分类，请先删除下级分类'));
        }
        $good_category=Db::name('good_category')->where(['id'=>$param['id']])->delete();

        if(!$good_category){
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
        return json(array('code'=>1,'msg'=>'删除成功'));
    }


    /**
     * ajax 修改指定表数据字段  一般修改状态 比如 是否推荐 是否开启 等 图标切换的
     * table,id,id_value,field,value
     */
    public function changeTableVal(){
        $param=$this->request->param();
        $table=$param['table'];
        $id=$param['id'];
        $id_value=$param['id_value'];
        $field=$param['field'];
        $value=$param['value'];
        Db::name($table)->where("$id=$id_value")->data([$field=>$value])->update();
    }





    //标签组
    public function commodity_biaoqian(){




    }




}
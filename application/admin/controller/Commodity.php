<?php


namespace app\admin\controller;


<<<<<<< HEAD
=======
use think\Console;
>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7
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
<<<<<<< HEAD

           dump(input());die();

=======
            $param=$this->request->param();
            dump($param);die();
            if($param['sort']<0){
                return json(array('code'=>0,'msg'=>'排序数字不能小于0'));
            }
            $ret['sort']=$param['sort'];
            if(!empty($param['sales_sum'])) {
                if (!preg_match("/^[1-9]\d*$/", $param['give_integral'])) {   //积分
                    return json(array('code' => 0, 'msg' => '请输入正确的赠送积分'));
                }
                $ret['give_integral']=$param['give_integral'];
            }

            if(!empty($param['sales_sum'])){
                if(!preg_match(   "/^[1-9]\d*$/",$param['sales_sum'])){   //销量
                    return json(array('code'=>0,'msg'=>'请输入正确的销量'));
                }
                $ret['sales_sum']=$param['sales_sum'];
            }




                if(!empty($param['shipping_money'])){
                    if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['shipping_money'])){   //邮费
                        return json(array('code'=>0,'msg'=>'请输入正确的邮费金额'));
                    }
                    $ret['shipping_money']=$param['shipping_money'];
                }


                 if(!empty($param['store_count'])){
                     if(!preg_match(   "/^[1-9]\d*$/",$param['shipping_money'])){   //库存
                         return json(array('code'=>0,'msg'=>'请输入正确的库存数量'));
                     }
                     $ret['store_count']=$param['store_count'];
                 }




            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['market_price'])){   //市场价
                return json(array('code'=>0,'msg'=>'请输入正确的市场价'));
            }
            $ret['market_price']=$param['market_price'];
            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['shop_price'])){   //本店价
                return json(array('code'=>0,'msg'=>'请输入正确的本店价'));
            }
            $ret['shop_price']=$param['shop_price'];
            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['cost_price'])){   //成本价
                return json(array('code'=>0,'msg'=>'请输入正确的成本价'));
            }
            $ret['cost_price']=$param['cost_price'];
            if(empty($param['parent_id_1']) && empty($param['parent_id_2'])  && empty($param['parent_id_3']) ){
                return json(array('code'=>0,'msg'=>'请选择商品分类'));
            }

            if(!empty($param['parent_id_1'])  && empty($param['parent_id_2']) ||empty($param['parent_id_3'])) {
                $ret['goods_category_id']=$param['parent_id_1'];
            }
            if(!empty($param['parent_id_2']) && empty($param['parent_id_3'])){
                $ret['goods_category_id']=$param['parent_id_2'];
            }

            if(!empty($param['parent_id_3'])){
                $ret['goods_category_id']=$param['parent_id_3'];
            }
            if(isset($param['is_free_shipping'])){   //是否包邮
                $ret['is_free_shipping']=1;
            }else{
                $ret['is_free_shipping']=0;
            }
            if(isset($param['is_tuijian'])){   //是否推荐
                $ret['is_tuijian']=1;
            }else{
                $ret['is_tuijian']=0;
            }
            if(isset($param['is_show'])){      //是否显示
                $ret['is_show']=1;
            }else{
                $ret['is_show']=0;
            }
            if(isset($param['is_on_sale'])){      //是否上架
                $ret['is_on_sale']=1;
            }else{
                $ret['is_on_sale']=0;
            }
            if(isset($param['is_hot'])){      //是否热卖
                $ret['is_hot']=1;
            }else{
                $ret['is_hot']=0;
            }
            if(isset($param['is_model'])){      //是否开启规格
                $ret['is_model']=1;
            }else{
                $ret['is_model']=0;
            }
            if(array_key_exists('autuimg',$param)){
                $aut= $param['autuimg'];
                $ret['original_img']=$param['autuimg'][0];  //第一张图片为首页展示图
                if(strpos($ret['original_img'],'base64') !== false){
                    $ret['original_img']=base64toimg($ret['original_img']);
                }
            }
            $ret['goods_sn']='xsk'.date('YmdHis').rand(1111,9999);     //商品编号
            $ret['on_time']=date('Y-m-d H:i:s');                  //上架时间
            $ret['goods_name']=$param['goods_name'];
            $ret['goods_gjc']=$param['goods_gjc'];
            $ret['is_reduce']=$param['is_reduce'];
            $ret['goods_name']=$param['goods_name'];
            $ret['goods_name']=$param['goods_name'];
            if(isset($param['goods_content'])){

                $ret['goods_content']=$param['goods_content'];
            }

            $goodid=model('goods')->goods_add($ret);
            if(isset($aut)){
                $list = array();
                foreach ($aut as $k=>$v){
                    $b['goods_id']=$goodid;
                    if(strpos($v,'base64') !== false){
                        $b['path']=base64toimg($v);
                    }
                    array_push($list, $b);
                }
                Db::name('goods_img')->insertAll($list);
            }
            if(isset($param['lv1'])){
                $attr_key=$param['lv1'];
                $lv1=array();
                foreach ($attr_key as $k=>$v){
                    $l['goods_id']=$goodid;
                    $l['attr_name']=$v;
                    array_push($lv1, $l);
                }
                Db::name('goods_attr_key')->insertAll($lv1);
            }
            if(isset($param['lv2'])){
                $attr_key=$param['lv2'];
                $lv1=array();
                foreach ($attr_key as $k=>$v){
                    $l['goods_id']=$goodid;
                    $l['attr_name']=$v;
                    array_push($lv1, $l);
                }
                Db::name('goods_attr_key')->insertAll($lv1);
            }
>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7
        }
        $cat_list = Db::name('good_category')->where("parent_id = 0")->select();   //获取一级菜单
        $this->assign([
            'cat_list' =>$cat_list
        ]);
<<<<<<< HEAD

=======
>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7
        return $this->fetch();
    }



<<<<<<< HEAD
=======
    public function save_attr(){
        if (request()->isAjax()){
            $data = request()->post();
            $key = json_decode($data['key'], true);
            $value = json_decode($data['value'], true);
            $key_id = [];
            foreach ($key as $k){
                $list['attr_name']=$k;
                $key_id=Db::name('goods_attr_key')->insertGetId($list);
            }
            foreach ($value as $key => $v) {
                $attr_key_id = $key_id[$key];
                $tm_v = [];
                foreach ($v as $v1) {
                        $arr['attr_key_id'] = $attr_key_id;
                        $arr['attr_value'] = $v1;
                        Db::name('goods_attr_key')->insertGetId($arr);

                       $tm_v[] = $attr_value->symbol;

                }

            }






        }


    }





>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7

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

<<<<<<< HEAD
    //添加商品属性

=======

    //添加商品属性
>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7
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
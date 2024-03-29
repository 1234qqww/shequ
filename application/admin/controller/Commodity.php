<?php


namespace app\admin\controller;


use app\admin\model\Goods;
use think\Console;

use think\Db;

class Commodity extends Base
{
    //销售中的商品
    public function commodity(){
        if(request()->isAjax()){


            $admin=session('admin');
            $merchantid=session('merchantid');
            $get=input();
            $where['store_count']= array('neq',0);
            $where['state']= 1;

            if($merchantid!=-1 ){               //超级管理员权限
                $where['good_id']= session('good');
            }else{
                $where['good_id']= -1;
            }

            if(isset($get['goods_name']) && $get['goods_name']!=''){
                $where['goods_name']=array('like','%'.$get['goods_name'].'%');
            }


            return model('goods')->goods($where);
        }

        return $this->fetch();
    }

    //添加商品
    public function add_commodity(){
        if(request()->isAjax()){
            $param=$this->request->param();
            $ret['sort']=$param['sort'];
            if($param['is_jifen']==0){
                if(!empty($param['sales_sum'])) {
                    if (!preg_match("/^[1-9]\d*$/", $param['give_integral'])) {   //积分
                        return json(array('code' => 0, 'msg' => '请输入正确的赠送积分'));
                    }
                    $ret['give_integral']=$param['give_integral'];
                }
                if(empty($param['parent_id_1']) && empty($param['parent_id_2'])  && empty($param['parent_id_3']) ){
                    return json(array('code'=>0,'msg'=>'请选择商品分类'));
                }
                if(!empty($param['parent_id_1'])  && empty($param['parent_id_2']) ||empty($param['parent_id_3'])) {
                    return json(array('code'=>0,'msg'=>'请选择二三级分类'));
                }
                if(!empty($param['parent_id_2']) && empty($param['parent_id_3'])){
                    $ret['goods_category_id']=$param['parent_id_2'];
                }
                if(!empty($param['parent_id_3'])){
                    $ret['goods_category_id']=$param['parent_id_3'];
                }
            }else{
                if(empty($param['consume_jifen'])){
                    return json(array('code' => 0, 'msg' => '请填写消耗积分'));
                }
                if (!preg_match("/^[1-9]\d*$/", $param['consume_jifen'])) {   //积分
                    return json(array('code' => 0, 'msg' => '请输入正确的消耗积分'));
                }
                $ret['consume_jifen']=$param['consume_jifen'];
                if(empty($param['goods_jifenid'])){
                    return json(array('code'=>0,'msg'=>'请选择积分分类'));
                }
                $ret['goods_jifenid']=$param['goods_jifenid'];
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
                     if(!preg_match(   "/^[1-9]\d*$/",$param['store_count'])){   //库存
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

            if(isset($param['is_newshop'])){      //是否新品
                $ret['is_newshop']=1;
            }else{
                $ret['is_newshop']=0;
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
            $ret['good_id']=session('merchantid');
            $ret['is_jifen']=$param['is_jifen'];
            if(isset($param['goods_content'])){
                $ret['goods_content']=$param['goods_content'];
            }
            $goodid=model('goods')->goods_add($ret);   //返回商品id
            if(isset($aut)){
                $list = array();
                foreach ($aut as $k=>$v){
                    $b['goods_id']=$goodid;
                    if(strpos($v,'base64') !== false){
                        $b['path']=base64toimg($v);
                    }else{
                        $b['path']=$v;
                    }
                    array_push($list, $b);
                }
                Db::name('goods_img')->insertAll($list);
            }
            if(isset($param['is_model'])){      //是否开启规格
                $good_id=-1;
                Db::name('goods_attr_key')->where(['goods_id' =>$good_id])->data(['goods_id' =>$goodid])->update();
                Db::name('goods_attr_value')->where(['goods_id' =>$good_id])->data(['goods_id' =>$goodid])->update();
                Db::name('goods_item_sku')->where(['goods_id' =>$good_id])->data(['goods_id' =>$goodid])->update();
                $sku=Db::name('goods_item_sku')->where(['goods_id' =>$good_id])->select();
                $num=0;
                foreach ($sku as $k){
                    $num+=$k['sku_store_count'];
                }
                Db::name('goods')->where(['id'=>$goodid])->data(['store_count'=>$num])->update();

            }
            return json(array('code'=>1,'msg'=>'储存成功'));

        }
        $cat_list = Db::name('good_category')->where("parent_id = 0")->select();   //获取一级菜单
        $jife=Db::name('jifen_class')->select();
        $this->assign([
            'cat_list' =>$cat_list,
            'jifen'=>$jife
        ]);
        return $this->fetch();
    }

    //修改商品
    public function edit_commodity(){
        if(request()->isAjax()){
            $param=$this->request->param();
            $ret['sort']=$param['sort'];
            if($param['is_jifen']==0){
                if(!empty($param['sales_sum'])) {
                    if (!preg_match("/^[0-9]\d*$/", $param['give_integral'])) {   //积分
                        return json(array('code' => 0, 'msg' => '请输入正确的赠送积分'));
                    }
                    $ret['give_integral']=$param['give_integral'];
                }
                if(empty($param['parent_id_1']) && empty($param['parent_id_2'])  && empty($param['parent_id_3']) ){
                    return json(array('code'=>0,'msg'=>'请选择商品分类'));
                }
                if(!empty($param['parent_id_1'])  && empty($param['parent_id_2']) ||empty($param['parent_id_3'])) {
                    return json(array('code'=>0,'msg'=>'请选择二三级分类'));
                }
                if(!empty($param['parent_id_2']) && empty($param['parent_id_3'])){
                    $ret['goods_category_id']=$param['parent_id_2'];
                }
                if(!empty($param['parent_id_3'])){
                    $ret['goods_category_id']=$param['parent_id_3'];
                }
            }else{
                if(empty($param['consume_jifen'])){
                    return json(array('code' => 0, 'msg' => '请填写消耗积分'));
                }
                if (!preg_match("/^[1-9]\d*$/", $param['consume_jifen'])) {   //积分
                    return json(array('code' => 0, 'msg' => '请输入正确的消耗积分'));
                }
                $ret['consume_jifen']=$param['consume_jifen'];
                if(empty($param['goods_jifenid'])){
                    return json(array('code'=>0,'msg'=>'请选择积分分类'));
                }
                $ret['goods_jifenid']=$param['goods_jifenid'];
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
                if(!preg_match(   "/^[1-9]\d*$/",$param['store_count'])){   //库存
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
            if(isset($param['is_newshop'])){      //是否新品
                $ret['is_newshop']=1;
            }else{
                $ret['is_newshop']=0;
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
            $ret['goods_name']=$param['goods_name'];
            $ret['goods_gjc']=$param['goods_gjc'];
            $ret['is_reduce']=$param['is_reduce'];
            $ret['is_jifen']=$param['is_jifen'];
            if(isset($param['goods_content'])){
                $ret['goods_content']=$param['goods_content'];
            }
            Db::name('goods')->where(['id'=>$param['id']])->data($ret)->update();   //修改商品基本资料

            if(isset($aut)){
                $list = array();
                foreach ($aut as $k=>$v){
                        $b['goods_id']=$param['id'];
                    if(strpos($v,'base64') !== false){
                        $b['path']=base64toimg($v);
                    }else{
                        $b['path']=$v;
                    }
                    array_push($list, $b);
                }
                model('goods_img')->getSelectAll($param['id'],$list);
            }

            if(isset($param['is_model'])){
                $good_id=-1;
                $goods_attr_key=Db::name('goods_attr_key')->where(['goods_id'=>$good_id])->select();
                $goods_attr_value=Db::name('goods_attr_value')->where(['goods_id'=>$good_id])->select();
                $goods_item_sku=Db::name('goods_item_sku')->where(['goods_id'=>$good_id])->select();

                if($goods_attr_key){
                    Db::name('goods_attr_key')->where(['goods_id'=>$param['id']])->delete();
                    Db::name('goods_attr_key')->where(['goods_id'=>$good_id])->data(['goods_id'=>$param['id']])->update();
                }
                if($goods_attr_value){
                    Db::name('goods_attr_value')->where(['goods_id'=>$param['id']])->delete();
                    Db::name('goods_attr_value')->where(['goods_id'=>$good_id])->data(['goods_id'=>$param['id']])->update();
                }
                if($goods_item_sku){
                    Db::name('goods_item_sku')->where(['goods_id'=>$param['id']])->delete();
                    Db::name('goods_item_sku')->where(['goods_id'=>$good_id])->data(['goods_id'=>$param['id']])->update();
                }
                     $sku=Db::name('goods_item_sku')->where(['goods_id'=>$param['id']])->select();
                $num=0;
                foreach ($sku as $k){
                    $num+=$k['sku_store_count'];
                }
                Db::name('goods')->where(['id'=>$param['id']])->data(['store_count'=>$num])->update();
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $list=array();
        $goods=Db::name('goods')->where(input())->find();  //商品基本信息
        if($goods['is_jifen']==0){
            $goods_category=model('good_category')->arr_push($goods['goods_category_id'],$list);
            $goods['goods_category_id1']=$goods_category[1];
            $goods['goods_category_id2']=$goods_category[0];
            $cat_list1 = Db::name('good_category')->where("parent_id = 0")->select();   //获取一级菜单
            $cat_list2= Db::name('good_category')->where("parent_id=$goods_category[1]")->select();   //获取3级菜单
            $cat_list3= Db::name('good_category')->where("parent_id=$goods_category[0]")->select();   //获取3级菜单
        }
        $jife=Db::name('jifen_class')->select();

        $goods_img=Db::name('goods_img')->where(['goods_id'=>$goods['id']])->select(); //商品图片
        $goods_attr_key=Db::name('goods_attr_key')->where(['goods_id'=>$goods['id']])->select();   //sku key值
        $goods_attr_value = Db::name('goods_attr_value')->where(['goods_id'=>$goods['id']])->select();
        $goods_item_sku=Db::name('goods_item_sku')->where(['goods_id'=>$goods['id']])->select();
        foreach ($goods_attr_value as $k=>$v){
            foreach ($goods_attr_key as $x=>$y){
                if($v['attr_key_id']==$y['id']){
                    $goods_attr_key[$x]['itemattrval'][$k]=$v;
                }
            }
        }
        $this->assign([
            'goods_imgs'=>json_encode($goods_img,320),
            'goods_img'=>$goods_img,
            'goods'=>$goods,
            'cat_list1'=>isset($cat_list1)?$cat_list1:'',
            'cat_list2'=>isset($cat_list2)?$cat_list2:'',
            'cat_list3'=>isset($cat_list3)?$cat_list3:'',
            'itemAttr'=>$goods_attr_key,
            'itemSku'=>json_encode($goods_item_sku,320),
            'jifen'=>isset($jife)?$jife:''
        ]);
        return $this->fetch();

    }


    //删除商品
    public function del_commodity(){

        if(request()->isAjax()){
            $state=2;
            $goods=model('goods')->del_commodity(input(),$state); //修改商品状态，软删除
            if(!$goods){
                return json(array('code'=>0,'msg'=>'删除失败'));

            }
            return json(array('code'=>1,'msg'=>'删除成功'));


        }
    }
    public function save_attr(){
        if (request()->isAjax()){
            $data = request()->post();
            $key = json_decode($data['key'], true);
            $value = json_decode($data['value'], true);
            $goods_id = -1;
            $key_id = [];
            Db::name('goods_attr_key')->where(['goods_id' => $goods_id])->delete();  //删除之前创建的未使用的规格名
            foreach ($key as $k){
                $list['attr_name']=$k;
                $list['goods_id']=$goods_id;
                $key_id[]=Db::name('goods_attr_key')->insertGetId($list);
            }
            $tm_v = [];
            Db::name('goods_attr_value')->where(['goods_id' => $goods_id])->delete();  //删除之前创建未使用的参数名
            foreach ($value as $key => $v) {
                $attr_key_id = $key_id[$key];
                foreach ($v as $v1) {
                        $arr['attr_key_id'] = $attr_key_id;
                        $arr['attr_value'] = $v1;
                        $arr['goods_id']=$goods_id;
                        Db::name('goods_attr_value')->insertGetId($arr);
                       $tm_v[] = $v1;
                }
            }


            return json(array('code'=>1,'msg'=>'操作成功','data'=>['key'=>$key_id,'value'=>$tm_v]));
        }

    }
    //保存sku
    public function save_sku(){
        if(request()->isAjax()){
            $data=request()->post();

            Db::name('goods_item_sku')->where(['goods_id'=>-1])->delete();
            foreach ($data as $item) {
                $arr['goods_id']=-1;
                $arr['sku_market_price']=$item['sku_market_price'];
                $arr['sku_shop_price']=$item['sku_shop_price'];
                $arr['sku_cost_price']=$item['sku_cost_price'];
                $arr['sku_store_count']=$item['sku_store_count'];
                $arr['attr_path']=$item['symbol'];
                Db::name('goods_item_sku')->insert($arr);
            }
        }
    }


    //回收站
    public function commodity_del(){
        if(request()->isAjax()){
            $admin=session('admin');
            $get=input();
            $where['state']=2;
            if($admin['role_id']!=1){               //超级管理员权限
                $where['good_id']= session('good');
            }
            if(isset($get['goods_name']) && $get['goods_name']!=''){
                $where['goods_name']=array('like','%'.$get['goods_name'].'%');
            }
            return model('goods')->goods($where);
        }
        return $this->fetch();
    }

    //已售罄
    public function commodity_out(){
        if(request()->isAjax()){
            $admin=session('admin');
            $get=input();
            $where['store_count']= array('eq',0);
            $where['state']= 1;
            if($admin['role_id']!=1){               //超级管理员权限
                $where['good_id']= session('good');
            }
            if(isset($get['goods_name']) && $get['goods_name']!=''){
                $where['goods_name']=array('like','%'.$get['goods_name'].'%');
            }
            return model('goods')->goods($where);
        }
        return $this->fetch();
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
    //批量删除
    public function commodity_delAll(){
        $id = input();

        foreach ($id['id'] as $k){
            $state=2;
            model('goods')->del_commodity(['id'=>$k],$state); //修改商品状态，软删除
        }
        return json(array('code'=>1,'msg'=>'删除成功'));
    }
    //回收站恢复商品
    public function commodity_huifu(){
        $state=1;
      $goods=model('goods')->del_commodity(input(),$state); //修改商品状态，恢复

        if(!$goods){
            return json(array('code'=>0,'msg'=>'恢复失败'));

        }
        return json(array('code'=>1,'msg'=>'恢复成功'));

    }
    public function imageUrl($content) {

        $url = "http://".$_SERVER['SERVER_NAME'];
        $pregRule = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/";
        $content = preg_replace($pregRule, '<img src="'.$url.'${1}" style="max-width:100%">', $content);
        return $content;
    }

    public function commodity_jifen_class(){
        if(request()->isAjax()){
          return  Db::name('jifen_class')->order('order asc')->paginate(15);
        }
        return $this->fetch();
    }

    public function commodity_jifen_edit(){
        if(request()->isAjax()){
            $param=$this->request->param();
            if(isset($param['is_show'])){
                $param['is_show']=1;
            }else{
                $param['is_show']=0;
            }
            $shiping_class= Db::name('jifen_class')->where(['id'=>$param['id']])->update($param);
            if(!$shiping_class){
                return json(array('code'=>0,'msg'=>'修改失败'));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $data=Db::name('jifen_class')->where(['id'=>input('id')])->find();
        $this->assign([
                'data'=>$data
            ]

        );
        return $this->fetch();
    }

    public function commodity_jifen_add(){
        if(request()->isAjax()){
            $param=$this->request->param();
            if(isset($param['is_show'])){
                $param['is_show']=1;
            }else{
                $param['is_show']=0;
            }
            $shiping_class= Db::name('jifen_class')->insert($param);
            if(!$shiping_class){
                return json(array('code'=>0,'msg'=>'添加失败'));
            }
            return json(array('code'=>1,'msg'=>'添加成功'));

        }
        return $this->fetch();
    }

    public function commodity_jifen_del(){

       $goods=Db::name('goods')->where(['goods_jifenid'=>input('id')])->select();

       if($goods){
           return json(array('code'=>0,'msg'=>'该分类下存在商品，请先删除商品才能删除分类'));
       }
        $good_category=Db::name('jifen_class')->where(['id'=>input('id')])->delete();
        if(!$good_category){
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
        return json(array('code'=>1,'msg'=>'删除成功'));


    }





}
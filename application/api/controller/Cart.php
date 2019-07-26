<?php


namespace app\api\controller;


use think\Config;
use think\Db;


class Cart extends Base
{
    //产品加入购物车
    public function cart_add(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $sku=model('goods_item_sku')->selectSku($param['skuid'],$param['goods_id']);
        $goods_cart= model('goods_cart')->cart_find(['goods_id'=>$param['goods_id'],'userid'=>$param['userid'],'sku_id'=>$sku['id']]);
        if(!$goods_cart){

            $where=array('id'=>$param['goods_id']);
            $field='id,goods_name,shop_price,good_id,prom_type,original_img';
            $goods=model('goods')->goodsFind($where,$field);
            $cart['goods_sum']=$param['num'];               //购买数量
            $cart['goods_id']=$param['goods_id'];           //商品id
            $cart['userid']=$param['userid'];               //用户id
            $cart['prom_type']=$goods['prom_type'];          //订单类型
            $cart['good_id']=$goods['good_id'];               //商户id
            $cart['goods_name']=$goods['goods_name'];         //商品名
            $cart['goods_price']=$goods['shop_price'];   //商品价格
            $cart['original_img']=$goods['original_img'];
            $cart['max_sum']=99;
            $cart['atime']=date('Y-m-d H:i:s');
            if(!$param['skuid']){
                if( !model('goods_cart')->cart_add($cart)){
                    return  json(array('code'=>0,'msg'=>'加入购物车失败'));
                }else{
                    return  json(array('code'=>1,'msg'=>'加入购物车成功'));
                }
            }else{

                $cart['goods_price']=$sku['sku_shop_price'];
                $cart['sku_id']=$sku['id'];
                if( !model('goods_cart')->cart_add($cart)){
                    return  json(array('code'=>0,'msg'=>'加入购物车失败'));
                }else{
                    return  json(array('code'=>1,'msg'=>'加入购物车成功'));
                }
            }
        }else{
            $where1=array('id'=>$goods_cart['id']);
            $edit=Db::name('goods_cart')->where($where1)->data(['atime'=>date('Y-m-d H:i:s')])->setInc('goods_sum',$param['num']);
            if(!$edit){
                return  json(array('code'=>0,'msg'=>'加入购物车失败'));
            }else{
                return  json(array('code'=>1,'msg'=>'加入购物车成功'));
            }

        }
    }

    //购物车页面
    public function cart_index(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $goods_cart=model('goods_cart')->cart_select($param['userid']);
        return  json(array('code'=>1,'msg'=>'加载成功','data'=>$goods_cart));
    }

    //更新购物车中的购买数量
    public function cart_sumAdd(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $where=array('id'=>$param['cart_id']);
        $data=array('goods_sum'=>$param['num']);
       if (model('goods_cart')->cart_sumAdd($where,$data)){

           return  json(array('code'=>1,'msg'=>'更新成功'));
       }
        return  json(array('code'=>0,'msg'=>'更新失败'));
    }


    //单个删除购物车商品
    public function cart_cartDel(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        if($param['type']==1){
           if(model('goods_cart')->cart_cartDel($param['cart_ids'])){
               return  json(array('code'=>1,'msg'=>'删除成功'));
           }
        }else{
            $cart_ids=explode(",",$param['cart_ids']);
            $cart_ids= array_filter($cart_ids);
           foreach ($cart_ids as $k=>$v){
                 model('goods_cart')->cart_cartDel($v);
           }
            return  json(array('code'=>1,'msg'=>'删除成功'));
        }


    }







}
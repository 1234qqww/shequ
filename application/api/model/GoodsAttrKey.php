<?php


namespace app\api\model;


use think\Db;
use think\Model;

class GoodsAttrKey extends Model
{
    //查询商品sku
    public function selectSku($id){

        $key=Db::name('goods_attr_key')->where(['goods_id'=>$id])->select();


        $value=Db::name('goods_attr_value')->where(['goods_id'=>$id])->select();

        foreach ($key as $k=>$v){
            foreach ($value as $x=>$y){
                    if($v['id']==$y['attr_key_id']){
                        $key[$k]['value'][]=$y;
                    }
            }
       }
        return $key;
    }

}
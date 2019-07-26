<?php


namespace app\api\model;


use think\Db;
use think\Model;

class GoodsItemSku extends Model
{
    //查询Sku
    public function selectSku($sku,$goods_id){

        $sku=explode(',',$sku);
        $list=array();
        foreach ($sku as $k=>$v){
            if($v){
                $value=Db::name('goods_attr_value')->where(['id'=>$v])->field('id,attr_value')->find();
                $list[]=$value['attr_value'];
            }
        }
        $list=join(",", $list);

        return  Db::name('goods_item_sku')->where(['goods_id'=>$goods_id,'attr_path'=>$list])->find();

    }

}
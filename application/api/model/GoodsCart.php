<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;

class GoodsCart extends Model
{
    //添加购物车
    public function cart_add($data){
      return  Db::name('goods_cart')->insert($data);

    }
    //购物车页面
    public function cart_select($userid){
        $sql = "select  good_id, GROUP_CONCAT(`id`),atime from hhtc_goods_cart where(userid=$userid) GROUP BY good_id order by atime desc ;";
        $url=Config::get('host');
//    $sql =  'SELECT b.good_id,b.atime from (SELECT a.good_id, a.atime FROM hhtc_goods_cart a ORDER BY a.atime DESC ) b GROUP BY b.good_id ';
        $goods_cart = DB::query($sql);

        $field='id,name';
        $list=array();
        foreach ($goods_cart as $k=>$v){
            if($v['good_id']!=-1){
                       $good=model('good')->getFind($field,$v['good_id']);
                       $list[$k]['good_name']=$good['name'];
            }else{
                        $list[$k]['good_name']='自营商品';
            }
            $list[$k]['cart_id']=explode(',',$v['GROUP_CONCAT(`id`)']);
        }
        foreach ($list as $k=>$v){
            foreach ($list[$k]['cart_id'] as $x=>$y){

                $cart_find=$this->cart_find(['id'=>$y]);
                $cart_find['goods_prices']=$cart_find['goods_price']*$cart_find['goods_sum'];
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$cart_find['original_img'])){
                    $cart_find['original_img']=$url['url'].$cart_find['original_img'];
                }
                $list[$k]['cart_id'][$x]=$cart_find;

                if($cart_find['sku_id']){
                    $goods_item_sku =Db::name('goods_item_sku')->where(['id'=>$cart_find['sku_id']])->find();

                    $list[$k]['cart_id'][$x]['sku']=$goods_item_sku['attr_path'];

                }else{
                    $list[$k]['cart_id'][$x]['sku']='';
                }

            }
        }

       return $list;
    }


    //条件查询购物表中的一条数据
    public function cart_find($where){
      return  Db::name('goods_cart')->where($where)->find();
    }


    //更新购物车中的购买数量
    public function cart_sumAdd($where,$data){

       return Db::name('goods_cart')->where($where)->update($data);

    }

    //删除购物车中商品
    public function cart_cartDel($id){
       return Db::name('goods_cart')->where(['id'=>$id])->delete();

    }


}
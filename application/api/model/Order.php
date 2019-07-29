<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;
use think\Paginator;

class Order extends Model
{
    //订单生成
    public function orders($goods_id,$user_id,$sum,$sku){
        $field='id,address_id';
        $url=Config::get('host');
        $address=model('user')->user_find(['id'=>$user_id],$field);                  //收货地址
        $goods=model('goods')->goodsFind(['id'=>$goods_id], true);                  //商品基本信息
        $price=$goods['shop_price'];
        $goods['shop_price_num']=$goods['shop_price']*$sum;                    //计算商品总价
        $goods_marketing =Db::name('goods_marketing')->where(['good_id'=>$goods['good_id']])->find();    //商户减免
        $marketing=0;
        $shipping_money=0;
        $goods['num']=$sum;
        if($sku!='undefined'){
            $goods['sku']=model('goods_item_sku')->selectSku($sku,$goods_id);            //查询商品sku
            $goods['shop_price_num']=$goods['sku']['sku_shop_price']*$sum;
            $price=$goods['sku']['sku_shop_price'];
        }else{
            $goods['sku']=0;
        }
            $total_amount=$goods['shop_price_num'];
        if($goods_marketing!=null){
            $content=json_decode($goods_marketing['content'],true);//商店优惠
            ksort($content);
            foreach ($content as $k=>$v){
                if($goods['shop_price_num']>=$k){
                    $marketing=$v;
                }
            }
        }
        if($goods['is_free_shipping']==0){
            $shipping_money=$goods['shipping_money'];
        }
        $goods['price_num']=$total_amount+$shipping_money;
        $goods['shop_price_num']=$goods['shop_price_num']+$shipping_money-$marketing;

        if($goods['good_id']!=-1){
            $good=Db::name('good')->field('id,name,pic')->where(['id'=>$goods['good_id']])->find();
        }else{
            $base=Config::get('base_config');
            $good['name']='平台自营';
            $good['pic']=$base['imgs'];
        }
        if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$good['pic'])){
            $good['pic']=$url['url'].$good['pic'];
        }

        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num']);
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id']);
        return  array('good'=>$good,'goods'=>$goods,'marketing'=>$marketing,'address'=>$address,'order'=>$order);

    }


    function order_add($user_id,$address,$shop_price_num,$marketing,$shipping_money,$prom_type,$good_id,$total_amount,$price_num){
        $address_id=0;
        if(!empty($address)){
           $address_id=$address['addressid'];
        }
        $data=array(
            'order_sn'=>'xsk'.date('YmdHis').rand(11111,99999),
            'user_id'=>$user_id,
            'user_address'=>$address_id,
            'goods_price'=> $total_amount,                    //商品总价
            'shipping_price'=>$shipping_money,                        //邮费
            'marketing_price'=>$marketing,                      //店铺折扣
            'order_amount'=>$shop_price_num,                           //实付金额
            'total_amount'=>$price_num,                           //订单总价
            'add_time'=>date('Y-m-d H:i:s'),                 //下单时间
            'order_prom_type'=>$prom_type,                    //订单类型
            'good_id'=>$good_id
        );
        $i=Db::name('order')->insertGetId($data);
        return $i;
    }
    function  order_good($order,$goods_id,$sum,$sku,$price,$good_id){
        $data=array(
            'goods_num'=>$sum,
            'order_id'=>$order,
            'goods_id'=>$goods_id,
            'sku'=>$sku,
            'price'=>$price,
            'good_id'=>$good_id,

        );
      return  Db::name('order_goods')->insert($data);
    }

    //批量购买
    public function order_All($cartsid,$user_id){
        $field='id,address_id';
        $url=Config::get('host');
        $address=model('user')->user_find(['id'=>$user_id],$field);                  //收货地址
        $cartsid=explode(',',$cartsid);
        foreach ($cartsid  as $k=>$v){
              $cart=Db::name('goods_cart')->where(['id'=>$v])->find();
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$cart['original_img'])){
                    $cart['original_img']=$url['url'].$cart['original_img'];
                }
              $cart['sku_id']=Db::name('goods_item_sku')->where(['id'=>$cart['sku_id']])->find();
              $cart['marketing']=Db::name('goods_marketing')->where(['good_id'=>$cart['good_id']])->find();
              $cart['goods_id']=Db::name('goods')->where(['id'=>$cart['goods_id']])->find();
              $list[]=$cart;
        }
        $data=$this->good($list,'good_id');
        foreach ($data as $k=>$v){
                $data[$k]['shipping_money_count']=0;    //总邮费
                $data[$k]['goods_price_count']=0;       //总价
                $data[$k]['goods_sum_count']=0;         //购买总数
                $data[$k]['marketing_count']=0;          //优惠总价格
                $data[$k]['total_amount']=0;
                $data[$k]['price_num']=0;
            foreach ($v as $x=>$y){
                if($y['goods_id']['is_free_shipping']==0){
                    $data[$k]['shipping_money_count']+=$y['goods_id']['shipping_money'];
                 }

                $data[$k]['goods_price_count']+=$y['goods_price']*$y['goods_sum'];
                $data[$k]['total_amount']+=$y['goods_price']*$y['goods_sum'];
                $data[$k]['goods_sum_count']+=$y['goods_sum'];
                if(!empty($y['marketing'])){
                    $content=json_decode($y['marketing']['content'],true);//商店优惠
                    ksort($content);
                    foreach ($content as $z=>$n){
                        if($data[$k]['goods_price_count']>=$z){
                            $data[$k]['marketing_count']=$n;
                        }
                    }
                }
                $a1=$data[$k]['goods_price_count']+$data[$k]['shipping_money_count']-$data[$k]['marketing_count'];
                $data[$k]['goods_price_counts']=$a1;
                $data[$k]['price_num']=$data[$k]['total_amount']+$data[$k]['shipping_money_count'];
                }
        }
        $zongjia=0;
        foreach ($data as $k=>$v){
            $order=$this->order_add($user_id,$address,$v['goods_price_counts'],$v['marketing_count'],$v['shipping_money_count'],0,$k,$v['total_amount'],$v['price_num']);
            $zongjia+=$v['goods_price_counts'];
            foreach ($v as $x=>$n){
                if(is_numeric($x) ){
                    $this->order_good($order,$n['goods_id']['id'],$n['goods_sum'],$n['sku_id']['attr_path'],$n['goods_price'],$k);
                }
            }
            if($k!=-1){
                $data[$k]['good']=Db::name('good')->field('id,name,pic')->where(['id'=>$k])->find();
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$data[$k]['good']['pic'])){
                    $data[$k]['good']['pic']=$url['url'].$data[$k]['good']['pic'];
                }
            }else{
                $base=Config::get('base_config');
                $data[$k]['good']['name']='平台自营';
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$base['imgs'])){
                    $data[$k]['good']['pic']=$url['url'].$base['imgs'];
                }
            }
            $order_id[]=$order;
            $data[$k]['orders']=$order;
        }
        return   array('address'=>$address,'order'=>$data,'zongjia'=>$zongjia,'order_id'=>$order_id);
    }
    public function order_status($where){
    $order=Db::name('order')->where($where)->select();

    foreach ($order as $k=>$v) {
        $num=0;
            $order_goods=Db::name('order_goods')->where(['order_id' => $v['id']])->select();
           foreach ($order_goods as $x=>$y){
               $goods=Db::name('goods')->where(['id'=>$y['goods_id']])->find();
               $goods['original_img']=url_imgs($goods['original_img']);
               $goods['total']=$y['goods_num'];
               $goods['sku_path']=$y['sku'];
               $goods['money']=$y['price'];
               $num+=$y['goods_num'];
               $order[$k]['goods'][]=$goods;
           }
           $order[$k]['good_nums']=$num;
            if($v['good_id'] != -1) {
                $good = model('good')->getFind('id,name,pic',['id' => $v['good_id']]);
                $good['pic'] = url_imgs($good['pic']);
            }else {
                $base = Config::get('base_config');
                $good['id'] = -1;
                $good['name'] = '平台自营';
                $good['pic'] = url_imgs($base['imgs']);
            }
            $order[$k]['good_id']=$good;
        }

       return $order;
    }




    //按照数组中其中一个字段分组
    function good($list,$good_id){
         $newArr=[];
          foreach ($list as $k=>$v){
              $newArr[$v[$good_id]][] = $v;
          }
        return $newArr;
    }
}
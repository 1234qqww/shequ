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
<<<<<<< HEAD
        if(empty($retail_id)){
            $goods['judge']=1;
            $goods['retail_id']='';
        }else{
            $goods['judge']=0;
            $goods['retail_id']=$retail_id;
        }
=======
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
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
        $goods['dissolution']=0;
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

<<<<<<< HEAD
        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num'],'',$goods['judge'], $goods['retail_id']);
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id']);
=======
        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num'],'');
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id'],$goods['sku']['id']);
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
        return  array('good'=>$good,'goods'=>$goods,'marketing'=>$marketing,'address'=>$address,'order'=>$order);

    }
    /**
     * 秒杀订单
     */
    public function order_seckill($goods_id,$user_id,$sum,$sku,$seckill){
        $field='id,address_id';
        $url=Config::get('host');
        $address=model('user')->user_find(['id'=>$user_id],$field);                  //收货地址
        $goods=model('goods')->goodsFind(['id'=>$goods_id], true);                  //商品基本信息

        $price=$goods['shop_price']-$seckill['discount'];
        $goods['shop_price']=$price;
        $goods['shop_price_num']=$price*$sum;                    //计算商品总价
//        $goods_marketing =Db::name('goods_marketing')->where(['good_id'=>$goods['good_id']])->find();    //商户减免
        $marketing=0;
        $shipping_money=0;
        $goods['num']=$sum;              //购买数量
        if($sku!='undefined'){
            $goods['sku']=model('goods_item_sku')->selectSku($sku,$goods_id);            //查询商品sku
            $price=$goods['sku']['sku_shop_price']-$seckill['discount'];
            $goods['sku']['sku_shop_price']=$price;
            $goods['shop_price_num']=$price*$sum;
        }else{
            $goods['sku']=0;
        }
        $total_amount=$goods['shop_price_num'];
//        if($goods_marketing!=null){
//            $content=json_decode($goods_marketing['content'],true);//商店优惠
//            ksort($content);
//            foreach ($content as $k=>$v){
//                if($goods['shop_price_num']>=$k){
//                    $marketing=$v;
//                }
//            }
//        }
        if($goods['is_free_shipping']==0){
            $shipping_money=$goods['shipping_money'];           //邮费
        }
        $goods['price_num']=$total_amount+$shipping_money;

        $goods['shop_price_num']=$goods['shop_price_num']+$shipping_money-$marketing;   //应付多少
        $goods['dissolution']=0;
        if($goods['good_id']!=-1){
            $good=Db::name('good')->field('id,name,pic')->where(['id'=>$goods['good_id']])->find();
        }else{
            $base=Config::get('base_config');
            $good['name']='平台自营';
            $good['pic']=$base['imgs'];
        }
        $good['pic']=url_imgs($good['pic']);
        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num'],'');
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id'],$goods['sku']['id']);
        return  array('good'=>$good,'goods'=>$goods,'marketing'=>$marketing,'address'=>$address,'order'=>$order);
    }

    /**
     * 团购订单
     */
    //订单生成
    public function grouporders($goods_id,$user_id,$sum,$sku,$prom,$group_id){
        if($group_id=='undefined'){
            $group_id=0;
        }
        $field='id,address_id';
        $url=Config::get('host');
        $address=model('user')->user_find(['id'=>$user_id],$field);                  //收货地址
        $goods=model('goods')->goodsFind(['id'=>$goods_id], true);                  //商品基本信息
        if($prom==2){
            $group=Db::name('group')->where('goods_id',$goods['id'])->find();
            $goods['shop_price']=$goods['shop_price']-$group['price'];
        }
<<<<<<< HEAD
        //判断商品在哪购买
        if(empty($retail_id)){
            $goods['judge']=1;
            $goods['retail_id']='';
        }else{
            $goods['judge']=0;
            $goods['retail_id']=$retail_id;
        }
=======
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
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
        $goods['dissolution']=0;

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
<<<<<<< HEAD
        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num'],$group_id,$goods['judge'],$goods['retail_id']);
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id']);
=======

        $order=$this->order_add($user_id,$address,$goods['shop_price_num'],$marketing,$shipping_money,$goods['prom_type'],$goods['good_id'],$total_amount, $goods['price_num'],$group_id);
        $this->order_good($order,$goods_id,$sum,$goods['sku']['attr_path'],$price,$goods['good_id'],$goods['sku']['id']);
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
        return  array('good'=>$good,'goods'=>$goods,'marketing'=>$marketing,'address'=>$address,'order'=>$order);

    }


<<<<<<< HEAD
    function order_add($user_id,$address,$shop_price_num,$marketing,$shipping_money,$prom_type,$good_id,$total_amount,$price_num,$group_id,$judge,$retail_id){
=======
    function order_add($user_id,$address,$shop_price_num,$marketing,$shipping_money,$prom_type,$good_id,$total_amount,$price_num,$group_id){
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
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
            'good_id'=>$good_id,
<<<<<<< HEAD
            'group_id'=>$group_id,
            'judge'=>$judge,
            'retail_id'=>$retail_id
=======
            'group_id'=>$group_id
>>>>>>> 9f0dfe6f6544a9cb0469885902ed88dcbe705e50
        );
        $i=Db::name('order')->insertGetId($data);
        return $i;
    }
    function  order_good($order,$goods_id,$sum,$sku,$price,$good_id,$sku_id){
        $data=array(
            'goods_num'=>$sum,
            'order_id'=>$order,
            'goods_id'=>$goods_id,
            'sku'=>$sku,
            'price'=>$price,
            'good_id'=>$good_id,
            'sku_id'=>$sku_id

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
            $order=$this->order_add($user_id,$address,$v['goods_price_counts'],$v['marketing_count'],$v['shipping_money_count'],0,$k,$v['total_amount'],$v['price_num'],'');
            $zongjia+=$v['goods_price_counts'];
            foreach ($v as $x=>$n){
                if(is_numeric($x) ){
                    $this->order_good($order,$n['goods_id']['id'],$n['goods_sum'],$n['sku_id']['attr_path'],$n['goods_price'],$k,$n['sku_id']['id']);
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
    $order=Db::name('order')->where($where)->order('add_time desc')->select();

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

    public function order_details($id){

        $order=Db::name('order')->where(['id'=>$id])->find();
        $address=Db::name('user_address')->where(['addressid'=>$order['user_address']])->find();

        $order_goods=Db::name('order_goods')->where(['order_id' => $order['id']])->select();
        foreach ($order_goods as $x=>$y){
            $goods=Db::name('goods')->field('id,original_img,goods_name')->where(['id'=>$y['goods_id']])->find();
               $y['original_img']=url_imgs($goods['original_img']);
               $y['goods_name']=$goods['goods_name'];
            $order['order_goods'][]=$y;
        }
        if($order['good_id'] != -1) {
            $good = model('good')->getFind('id,name,pic',['id' => $order['good_id']]);
            $good['pic'] = url_imgs($good['pic']);
        }else {
            $base = Config::get('base_config');
            $good['id'] = -1;
            $good['name'] = '平台自营';
            $good['pic'] = url_imgs($base['imgs']);
        }
        return array('good'=>$good,'order'=>$order,'address'=>$address);

    }
    public function order_refund_index($id){
        $order=Db::name('order')->where(['id'=>$id])->find();
        $order_goods=Db::name('order_goods')->where(['order_id' => $order['id']])->select();
        foreach ($order_goods as $x=>$y){
            $goods=Db::name('goods')->field('id,original_img,goods_name')->where(['id'=>$y['goods_id']])->find();
            $y['original_img']=url_imgs($goods['original_img']);
            $y['goods_name']=$goods['goods_name'];
            $order['order_goods'][]=$y;
        }
        $reason=Db::name('refund_reason')->select();
        $state=Db::name('refund_state')->select();
        return array('order'=>$order,'reason'=>$reason,'state'=>$state);
    }




    //按照数组中其中一个字段分组
    function good($list,$good_id){
         $newArr=[];
          foreach ($list as $k=>$v){
              $newArr[$v[$good_id]][] = $v;
          }
        return $newArr;
    }
    /**
     * 通过订单id查询已支付的团购订单
     */
    public function grouporder($order_id){
        return $this->with('user')->where('dissolution',0)->where('group_id',0)->where('id',$order_id)->where('order_status',0)->where('pay_status',1)->where('order_prom_type',2)->find();
    }
    /**
     * 通过订单编号查询团购人员
     */
    public function groupuser($group_id){
        return $this->with('user')->where('order_status',0)->where('pay_status',1)->where('order_prom_type',2)->where('group_id',$group_id)->select();
    }
    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('UserModel','id','user_id');
    }
    /**
     * 查询未开团的团购订单
     */
    public function regiment(){
        return $this->where('pay_status',1)->where('order_status',0)->where('order_prom_type',2)->where('group_id',0)->select();
    }
    /**
     * 通过id来查询订单
     */
    public function onedata($id){
        return $this->where('id',$id)->find();
    }

    /**
     * 团购解散后修改团购订单状态
     */
    public function dissolution($id){
        return $this->where('id',$id)->update(['dissolution'=>2]);
    }
    /**
     * 通过订单号来查询参加拼团的用户
     */
    public function hand($order_sn){
        return  $this->where('group_id',$order_sn)->select();

    }
    /**
     * 查询某门店所有的未支付的订单
     */
    public function retail($retail_id){
        return $this->where('order_status',0)->where('handle','0')->where('retail_id',$retail_id)->select();
    }
    /**
     * 查询某门店所有的已支付订单
     */
    public function payretail($retail_id){
        return $this->where('order_status',2)->where('handle','0')->where('retail_id',$retail_id)->select();
    }

     //  提交订单

    public function order_sub($order,$pay_id){
        $data=array(
            'pay_name'=>$pay_id==1?'微信支付':'余额支付',
            'order_status'=>1,                           //订单状态待发货
            'pay_status'=>1,                             //支付状态已支付
            'pay_time'=>date('Y-m-d H:i:s')
        );
      return Db::name('order')->where(['id'=>$order['id']])->update($data);

    }










}
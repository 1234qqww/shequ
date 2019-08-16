<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;

class Goods extends Model
{

    //根据分类id查询商品
    public function selectAllWhere($id,$page){
        $list=array();
        $where['store_count']= array('neq',0);
        $where['state']= 1;
        $where['is_show']=1;
        $category=$this->category($id,$list);
        $order='';
        if(!$category){
            $where['goods_category_id']=$id;
            return  $this->selectAll($where,$page,$order);
        }
        foreach ($category as $k=>$v){
            $category[$k]='goods_category_id='.$v;
        }
        $category=join(",",$category);
        $category=str_replace(',',' or ',$category);
        $page=($page-1)*20;

        $sql="SELECT * FROM  hhtc_goods where $category and store_count!=0 and state=1 and is_show=1 limit $page,20";

        $url=Config::get('host');
          $goods= DB::query($sql);
            foreach ($goods as $k=>$v){
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$v['original_img'])){

                    $goods[$k]['original_img']=$url['url'].$v['original_img'];
                }

            }

        return $goods;
    }
    //根据条件查询商品
    public function selectAll($where,$page,$order){
        $goods=Db::name('goods')->where($where)->order($order)->page($page)->limit(20)->select();
        $url=Config::get('host');
        foreach ($goods as $k=>$v){
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$v['original_img'])){

                $goods[$k]['original_img']=$url['url'].$v['original_img'];
            }
        }
      return $goods;

    }


  public  function  category($id,$list){
        $good_category=Db::name('good_category')->where(['parent_id'=>$id])->select();
        if($good_category){
            foreach ($good_category as $k=>$v){
                if($v['level']!=3){
                    $list=$this->category($v['id'],$list);
                }else{
                    $list[]=$v['id'];
                }
            }
        }
      return $list;
    }
    //查询单条商品
    public function goodsFind($where,$field){
        $goods=Db::name('goods')->field($field)->where($where)->find();
        $url=Config::get('host');
        if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$goods['original_img'])){

            $goods['original_img']=$url['url'].$goods['original_img'];
        }
        return $goods;
    }
    /**
     * 通过id查询商品
     */
    public function oneData($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 通过id查询商品
     */
    public function one($id){
        return $this->where('id',$id)->where('prom_type',2)->find();
    }
    /**
     * 店铺内的拼团商品
     */
    public function oneDatas($id,$good_id){
        return $this->where('id',$id)->where('good_id',$good_id)->find();
    }
//    /**
//     *
//     */
//    public function goods(){
//        return $this->hasOne('Goods','id','goods_id');
//    }

    //商品减库存，
    public function  store_count($id,$num,$sku_id){
        if(!empty($sku_id)){
         Db::name('goods_item_sku')->where(['id'=>$sku_id])->setDec('sku_store_count',$num);   //减sku库存
        }
        Db::name('goods')->where(['id'=>$id])->setDec('store_count',$num);   //减库存
    }
    //加展示销量，加实际销量
    public function sales_sum($id,$num){

        Db::name('goods')->where(['id'=>$id])->setInc('inventory_count',$num);              //加实际销量
        Db::name('goods')->where(['id'=>$id])->setInc('sales_sum',$num);   //加展示销量
    }
}
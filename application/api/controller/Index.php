<?php


namespace app\api\controller;


use think\Config;
use think\Db;

class Index extends Base
{

    /**
     * 商城首页
     */
    public function  index(){

        $param=$this->request->param();

        unset($param['token']);
        $slide='';
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }

        $good_category=model('good_category')->selectTuiJianAll();
        if(isset($param['position'])){
            $slide=model('slide')->selectPosition($param['position']);
        }

        if($param['category_id']!=0){
            $goods=model('goods')->selectAllWhere($param['category_id'],$param['page']);
        }else{
            $where['store_count']= array('gt',0);
            $where['state']= 1;
            $where['is_show']=1;
            $order='sort asc';
            $goods=model('goods')->selectAll($where,$param['page'],$order);
        }
        $arr=array('good_category'=>$good_category,'slide'=>$slide,'goods'=>$goods);
        return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));
    }
    //商品详情
    public function goods(){
        $param=$this->request->param();
        $type=$param['type'];
        $url=Config::get('host');
        $url=Config::get('host');
        $url=Config::get('host');
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $goods=Db::name('goods')->where(['id'=>$param['id']])->find();
        $goods_img=Db::name('goods_img')->where(['goods_id'=>$param['id']])->select();
        $url=Config::get('host');
        $goods=Db::name('goods')->where(['id'=>$param['id']])->find();
        $goods_img=Db::name('goods_img')->where(['goods_id'=>$param['id']])->select();
        $url=Config::get('host');
        $goods=Db::name('goods')->where(['id'=>$param['id']])->find();               //商品
        if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$goods['original_img'])){
            $goods['original_img']=$url['url'].$goods['original_img'];
        }

        $goods_img=Db::name('goods_img')->where(['goods_id'=>$param['id']])->select();    //查询商品相册
        $goods_discount=Db::name('goods_discount')->where(['goods_id'=>$goods['good_id'],'state'=>1,'total'=>array('neq',0)])->select();   //查询该商家是否发放优惠卷

        if($goods['good_id']==-1){
           $good=Config::get('base_config');
              if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$good['imgs'])){
                  $good['imgs']=$url['url'].$good['imgs'];
              }
        }else{
            $good=Db::name('good')->field('id,name,tel,pic')->where(['id'=>$goods['good_id']])->find();      //商户信息
            if($good){
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$good['pic'])){
                    $good['pic']=$url['url'].$good['pic'];
                }
            }
        }
        $reduction='';         //优惠卷最低优惠金额

        if($goods_discount){
            $num=count($goods_discount);
            $reduction=$goods_discount[0]['reduction'];
            if($num==1){
                $reduction=$goods_discount[0]['reduction'];
            }
            for ($i=0;$i<$num;$i++){
                         if($reduction>$goods_discount[$i]['reduction']){
                             $reduction= $goods_discount[$i]['reduction'];
                         }

            }
        }  //查出最低优惠金额
        foreach ($goods_img as $k=>$v){
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$v['path'])){
                $goods_img[$k]['path']=$url['url'].$v['path'];
            }
        }
        if($type==0){
            $arr=array('goods_img'=>$goods_img,'goods'=>$goods);
            return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));
        }

    }



     //商品规格
    public function good_model(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $sku=model('goods_attr_key')->selectSku($param['id']);
        return  json(array('code'=>1,'msg'=>'成功','data'=>$sku));
    }
    //商品sku选择
    public function choice_model(){
        $param=$this->request->param();
        unset($param['token']);
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $sku=model('goods_item_sku')->selectSku($param['sku'],$param['goods_id']);
        return  json(array('code'=>1,'msg'=>'','data'=>$sku));
    }


}
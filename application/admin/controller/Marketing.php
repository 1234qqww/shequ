<?php


namespace app\admin\controller;


use think\Db;
use think\Request;

class Marketing extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $admin=session('admin');

            $this->good_id=session('merchantid');

    }

    //营销
    public function marketing(){
        if(request()->isAjax()){
            $param=$this->request->param();
            $admin=session('admin');
            $price_max=$param['price_max'];
            $price_del=$param['price_del'];
            $arr=array();
            foreach ($price_max as $k=>$v){
                foreach ($price_del as $x=>$y){
                    if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$v) || !preg_match(   "/^\d+(?:\.\d{0,2})?$/",$y)){
                        return json(array('code'=>0,'msg'=>'请输入正确格式'));
                    }
                    if($k==$x){
                        $arr[$v]=$y;
                    }
                }
            }
            $data['content']=json_encode($arr);
            $merchantid=session('merchantid');
            $mark=Db::name('goods_marketing')->where(['good_id'=>$merchantid])->find();

            if($mark){
                Db::name('goods_marketing')->where(['id'=>$mark['id']])->data($data)->update();
                return ['code'=>1,'msg'=>'修改成功'];
            }
            $marketing=Db::name('goods_marketing') ->insert($data);
            return $marketing?['code'=>1,'msg'=>'添加成功']:['code'=>0,'msg'=>'添加失败'];
        }
        $merchantid=session('merchantid');

        $goods_marketing=Db::name('goods_marketing')->where(['good_id'=>$merchantid])->find();

        $content=json_decode($goods_marketing['content'],true);
        $this->assign(['content'=>$content]);


        return $this->fetch();
    }
    //满额包邮
    //优惠卷
    public function youhuijuan(){
        if(request()->isAjax()){
            $get=input();
            $admin=session('admin');
            $where=array();
            $where=array('state'=>1);
            if($admin['role_id']!=1){
                $where['goods_id']=session('good');
            }else{
                $where['goods_id']=-1;        //超级管理员id为-1
            }
            if(isset($get['dis_name']) && $get['dis_name']!=''){
                $where['dis_name']=array('like','%'.$get['dis_name'].'%');
            }
            return  Db::name('goods_discount')->where($where)->order('order asc')->paginate(15);
        }
        return $this->fetch();
    }

    //添加优惠卷
    public function youhuijuan_add(){
        if (request()->isAjax()){
            $param=$this->request->param();
            $admin=session('admin');
            if($admin['role_id']!=1){
                $param['goods_id']=session('good');
            }else{
                $param['goods_id']=-1;          //超级管理员id为-1
            }
            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['satisfy'])){
                return json(array('code'=>0,'msg'=>'请输入正确的格式哦！'));
            }
            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['reduction'])){
                return json(array('code'=>0,'msg'=>'请输入正确的优惠金额格式！'));
            }
            if(!preg_match(   "/^(0|[1-9][0-9]*)$/",$param['total'])){
                return json(array('code'=>0,'msg'=>'请数字正确的发行总数！'));
            }
            if(empty($param['time'])){
                return json(['code'=>0,'msg'=>'请选择使用时间限制']);
            }
            $one=explode('-',$param['time'],4);
//            $param['start_time']=strtotime($one[0].'-'.$one[1].'-'.$one[2]);
            $param['start_time']=$one[0].'-'.$one[1].'-'.$one[2];

//            $param['end_time']=strtotime($one[3]);
            $param['end_time']=$one[3];
            unset($param['time']);

            $goods_discount=Db::name('goods_discount')->insert($param);
            return  $goods_discount?['code'=>1,'msg'=>'添加成功']:['code'=>0,'msg'=>'添加失败'];

        }
        return $this->fetch();
    }
    //编辑优惠卷
    public function youhuijuan_edit(){
        if(request()->isAjax()){
            $param=$this->request->param();

            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['satisfy'])){
                return json(array('code'=>0,'msg'=>'请输入正确的格式哦！'));
            }
            if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['reduction'])){
                return json(array('code'=>0,'msg'=>'请输入正确的优惠金额格式！'));
            }
            if(!preg_match(   "/^(0|[1-9][0-9]*)$/",$param['total'])){
                return json(array('code'=>0,'msg'=>'请数字正确的发行总数！'));
            }
            if(empty($param['time'])){
                return json(['code'=>0,'msg'=>'请选择使用时间限制']);
            }
            $one=explode('-',$param['time'],4);
            $param['start_time']=$one[0].'-'.$one[1].'-'.$one[2];
            $param['end_time']=$one[3];
            unset($param['time']);

            $goods_discount=Db::name('goods_discount')->where(['id'=>$param['id']])->data($param)->update();

            return  $goods_discount?['code'=>1,'msg'=>'修改成功']:['code'=>0,'msg'=>'修改失败'];
        }

        $goods_discount= Db::name('goods_discount')->where(input())->find();

        $this->assign([
            'vo'=>$goods_discount
        ]);
        return $this->fetch();
    }
    //删除优惠卷
    public function youhuijuan_del(){
        if(request()->isAjax()){
            $goods_discount=Db::name('goods_discount')->where(input())->update(['state'=>2]);
            return  $goods_discount?['code'=>1,'msg'=>'删除成功']:['code'=>0,'msg'=>'删除失败'];


        }
    }

    //秒杀
    public function seckill(){
        if(request()->isAjax()){

       return Db::name('good_seckill')
                ->alias('s')
                ->join('goods g','s.goods_id=g.id')
                ->field('s.id,s.goods_id,s.good_id,s.discount,s.quantity,s.quantitys,s.purchase,s.start_time,s.end_time,g.id as gid,g.goods_name,g.original_img')
                ->where(['s.good_id'=>$this->good_id])
                ->paginate(15);
        }
        return $this->fetch();
    }


    public function seckill_add(){

        if(request()->isAjax()){
             $param=$this->request->param();
             $merchantid=session('merchantid');
             $start_time=explode(' ',$param['start_time']);



             if($param['quantity']<$param['purchase']){
                return json(array('code'=>0,'msg'=>'用户抢购数量不能比总数大！'));
             }
            Db::name('goods')->where(['id'=>$param['goods_id']])->update(['prom_type'=>1]);     //改变商品状态


             $arr=array(
                'goods_id'=>$param['goods_id'],
                 'good_id'=>$merchantid,
                 'discount'=>$param['discount'] ,                  //抢购优惠
                 'purchase'=>$param['purchase'],                 //用户限抢购数量
                 'quantity'=>$param['quantity'],                 //抢购数量
                 'start_time'=>$start_time[0],
                 'start_his'=>$start_time[1],
                 'end_time'=>$param['end_time'],
                 );
           $good_seckill=Db::name('good_seckill')->insert($arr);
           if(!$good_seckill){
               return json(array('code'=>0,'msg'=>'添加失败！'));
           }
            return json(array('code'=>1,'msg'=>'添加成功！'));



        }
        return $this->fetch();
    }


    public function seckill_edit(){
            if(request()->isAjax()){
                    $param=$this->request->param();
                    $merchantid=session('merchantid');
                    $start_time=explode(' ',$param['start_time']);
                    if($param['quantity']<$param['purchase']){
                        return json(array('code'=>0,'msg'=>'用户抢购数量不能比总数大！'));
                    }
                    $seckill=Db::name('good_seckill')->where(['id'=>$param['id']])->find();
                    if($seckill['goods_id']!=$param['goods_id']){
                        Db::name('goods')->where(['id'=>$seckill['goods_id']])->update(['prom_type'=>0]);     //改变商品状态
                        Db::name('goods')->where(['id'=>$param['goods_id']])->update(['prom_type'=>1]);
                    }
                    $arr=array(
                        'goods_id'=>$param['goods_id'],
                        'good_id'=>$merchantid,
                        'discount'=>$param['discount'] ,                  //抢购优惠
                        'purchase'=>$param['purchase'],                 //用户限抢购数量
                        'quantity'=>$param['quantity'],                 //抢购数量
                        'start_time'=>$start_time[0],
                        'start_his'=>$start_time[1],
                        'end_time'=>$param['end_time'],
                    );
                   $good_seckill=Db::name('good_seckill')->where(['id'=>$param['id']])->update($arr);
                    if(!$good_seckill){
                        return json(array('code'=>0,'msg'=>'修改失败！'));
                    }
                    return json(array('code'=>1,'msg'=>'修改成功！'));
            }
            $good_seckill=Db::name('good_seckill')
                    ->alias('s')
                    ->join('goods g','s.goods_id=g.id')
                    ->field('s.id,s.goods_id,s.good_id,s.discount,s.quantity,s.quantitys,s.purchase,s.start_time,s.start_his,s.end_time,g.id as gid,g.goods_name')
                    ->where(['s.id'=>input('id')])
                    ->find();
            $this->assign([
               'data'=>$good_seckill
            ]);

          return $this->fetch();
    }

    public function seckill_del(){
        $seckill=Db::name('good_seckill')->where(['id'=>input('id')])->find();
                 Db::name('goods')->where(['id'=>$seckill['goods_id']])->update(['prom_type'=>0]);     //改变商品状态
        $good_seckill=Db::name('good_seckill')->where(['id'=>input('id')])->delete();



       if(!$good_seckill){
            return json(array('code'=>0,'msg'=>'删除失败！'));
        }
        return json(array('code'=>1,'msg'=>'删除成功！'));


    }



}
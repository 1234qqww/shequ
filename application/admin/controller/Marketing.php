<?php


namespace app\admin\controller;


use think\Db;

class Marketing extends Base
{
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
            if($admin['role_id']!=1){
                $data['good_id']=session('good');
            }else{
                $data['good_id']=-1;        //超级管理员添加商品商户id为-1
            }
            $mark=Db::name('goods_marketing')->where(['good_id'=>$data['good_id']])->find();

            if($mark){
                Db::name('goods_marketing')->where(['id'=>$mark['id']])->data($data)->update();
                return ['code'=>1,'msg'=>'修改成功'];
            }
            $marketing=Db::name('goods_marketing') ->insert($data);
            return $marketing?['code'=>1,'msg'=>'添加成功']:['code'=>0,'msg'=>'添加失败'];
        }
        $admin=session('admin');
        if($admin['role_id']!=1){
            $good_id=session('good');
        }else{
            $good_id=-1;        //超级管理员添加商品商户id为-1
        }

        $goods_marketing=Db::name('goods_marketing')->where(['good_id'=>$good_id])->find();
        $content=json_decode($goods_marketing['content'],true);
        $this->assign(['content'=>$content]);

        return $this->fetch();
    }


<<<<<<< HEAD
    //优惠卷
=======
    //满额包邮
>>>>>>> 2fde78b8b5fb04e84606f6e939fe6f104b0539e8
    public function youhuijuan(){
        if(request()->isAjax()){
            $get=input();
            $admin=session('admin');
<<<<<<< HEAD
            $where=array('state'=>1);
=======
            $where=array();
>>>>>>> 2fde78b8b5fb04e84606f6e939fe6f104b0539e8
            if($admin['role_id']!=1){
                $where['goods_id']=session('good');
            }else{
                $where['goods_id']=-1;        //超级管理员id为-1
            }
            if(isset($get['dis_name']) && $get['dis_name']!=''){
                $where['dis_name']=array('like','%'.$get['dis_name'].'%');
            }
<<<<<<< HEAD
            return  Db::name('goods_discount')->where($where)->order('order asc')->paginate(15);
        }
=======
//

            return  Db::name('goods_discount')->where($where)->order('order asc')->paginate(15);

        }


>>>>>>> 2fde78b8b5fb04e84606f6e939fe6f104b0539e8
         return $this->fetch();
    }

    //添加优惠卷
<<<<<<< HEAD
=======


>>>>>>> 2fde78b8b5fb04e84606f6e939fe6f104b0539e8
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
<<<<<<< HEAD
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



=======






        }

        $goods_discount= Db::name('goods_discount')->where(input())->find();

        $this->assign([
            'vo'=>$goods_discount
        ]);
        return $this->fetch();
    }


>>>>>>> 2fde78b8b5fb04e84606f6e939fe6f104b0539e8
}
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


    //满额包邮
    public function shipping(){




        return $this->fetch();
    }


}
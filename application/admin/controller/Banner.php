<?php
/**
 * Created by IntelliJ IDEA.
 * User: yzwedu.com
 * Date: 2019/6/15
 * Time: 9:23
 */

namespace app\admin\controller;


use think\Db;

class Banner extends Base
{
    //首页轮播图列表
    public function  slide(){
        if(request()->isAjax()){

           return model('slide')->getListSlide();
        }

        return $this->fetch();
    }

    //添加轮播图
    public function add_banner(){
        if(request()->isAjax()){

            return model('slide')->add_banner(input());
        }
        return $this->fetch();
    }

    //编辑轮播图
    public function edit_banner(){
        if(request()->isAjax()){

           return model('slide')->edit_banner(input());
        }
      $data=$this->doModelAction(input(),false,'admin/slide','getArrayByMap');
      $this->assign([
         'data'=>$data['data']
      ]);
      return $this->fetch();
    }
    //删除轮播
    public function del_banner(){
        if(request()->isAjax()){
            return model('slide')->del_banner(input());
        }

    }
    //物流
    public function wuliu(){
        if(request()->isAjax()){
          return  Db::name('wuliu')->paginate(15);
        }
        return $this->fetch();
    }


    //添加物流
    public function add_wuliu(){
        if(request()->isAjax()){

          $wuliu=Db::name('wuliu')->insert(input());
          if(!$wuliu){
              return json(array('code'=>0,'msg'=>'添加失败'));
          }
            return json(array('code'=>1,'msg'=>'添加成功'));

        }
        return $this->fetch();
    }

    //修改物流
    public function edit_wuliu(){
        if(request()->isAjax()){
            $wuliu=Db::name('wuliu')->where(['id'=>input('id')])->update(input());
            if(!$wuliu){
                return json(array('code'=>0,'msg'=>'修改失败'));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $data=Db::name('wuliu')->where(['id'=>input('id')])->find();

        $this->assign([
           'data'=>$data
        ]);
        return $this->fetch();
    }
    public function del_wuliu(){
       $wuliu= Db::name('wuliu')->where(['id'=>input('id')])->delete();
        if(!$wuliu){
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
           return json(array('code'=>1,'msg'=>'删除成功'));
    }

    public function refund_state(){
        if(request()->isAjax()){
           return Db::name('refund_state')->paginate(15);
        }
        return $this->fetch();
    }


    public function add_refund_state(){
        if(request()->isAjax()){
           $refund_state=Db::name('refund_state')->insert(input());
            if(!$refund_state){
                return json(array('code'=>0,'msg'=>'添加失败'));
            }
            return json(array('code'=>1,'msg'=>'添加成功'));
        }

        return $this->fetch();
    }
    public function  edit_refund_state(){
        if(request()->isAjax()){
            $refund_state=Db::name('refund_state')->where(['id'=>input('id')])->update(input());
            if(!$refund_state){
                return json(array('code'=>0,'msg'=>'修改失败'));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
      $refund_state=Db::name('refund_state')->where(['id'=>input('id')])->find();
       $this->assign([
           'data'=>$refund_state
       ]) ;
       return $this->fetch();
    }



    public function refund_reason(){
        if(request()->isAjax()){
            return Db::name('refund_reason')->paginate(15);
        }
        return $this->fetch();
    }


    public function add_refund_reason(){
        if(request()->isAjax()){
            $refund_state=Db::name('refund_reason')->insert(input());
            if(!$refund_state){
                return json(array('code'=>0,'msg'=>'添加失败'));
            }
            return json(array('code'=>1,'msg'=>'添加成功'));
        }

        return $this->fetch();
    }
    public function  edit_refund_reason(){
        if(request()->isAjax()){
            $refund_state=Db::name('refund_reason')->where(['id'=>input('id')])->update(input());
            if(!$refund_state){
                return json(array('code'=>0,'msg'=>'修改失败'));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $refund_state=Db::name('refund_reason')->where(['id'=>input('id')])->find();
        $this->assign([
            'data'=>$refund_state
        ]) ;
        return $this->fetch();
    }

    public function del_refund_state(){
       $refund_state= Db::name('refund_state')->where(['id'=>input('id')])->delete();
        if(!$refund_state){
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
        return json(array('code'=>1,'msg'=>'删除成功'));

    }
    public function del_refund_reason(){
        $refund_state= Db::name('refund_reason')->where(['id'=>input('id')])->delete();
        if(!$refund_state){
            return json(array('code'=>0,'msg'=>'删除失败'));
        }
        return json(array('code'=>1,'msg'=>'删除成功'));

    }




}
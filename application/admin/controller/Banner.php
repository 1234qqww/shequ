<?php
/**
 * Created by IntelliJ IDEA.
 * User: yzwedu.com
 * Date: 2019/6/15
 * Time: 9:23
 */

namespace app\admin\controller;


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
    //测试
    public function ceshi(){


        return $this->fetch();
    }




}
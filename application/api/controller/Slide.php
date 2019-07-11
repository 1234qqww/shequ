<?php


namespace app\api\controller;


class Slide extends Base
{
    public function index()
    {
            $param=$this->request->param();
            unset($param['token']);
            $slide=model('slide')->selectPosition($param['position']);
            if(!$slide){
                return json(array('code'=>0,'msg'=>'暂无数据'));
            }
            return json(array('code'=>1,'msg'=>'商城首页轮播','data'=>$slide));

    }



}
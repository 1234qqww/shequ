<?php


namespace app\admin\controller;


use app\common\model\Txapi;
use think\Db;

class Goodshop extends Base
{
    //商铺更换背景图
    public function good_back(){

        if(request()->isAjax()){
            $param=$this->request->param();
            if (!empty($param['fanwei'])){
                if(!preg_match(   "/^\d+(?:\.\d{0,2})?$/",$param['fanwei'])){
                    return json(array('code'=>0,'msg'=>'请输入正确的范围'));
                }
            }
            if(strpos($param['pic'],'base64') !== false){
                $param['pic']=base64toimg($param['pic']);
            }
            if(strpos($param['pic_bg'],'base64') !== false){
                $param['pic_bg']=base64toimg($param['pic_bg']);
            }
            if(isset($param['is_fujin'])){
                $param['is_fujin']=1;
            }else{
                $param['is_fujin']=0;
            }
            $txapi=new Txapi();
            $a=$txapi->coordinate($param['address']);
            $param['lng']=$a->lng;//经度
            $param['lat']=$a->lat;//纬度
            $good=Db::name('good')->where(['id'=>$param['id']])->data($param)->update();
            if(!$good){

                return json(array('code'=>0,'msg'=>'修改失败'));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }
        $id=session('good');
        $good=Db::name('good')->where(['id'=>$id])->find();
        $this->assign([
            'good'=>$good
        ]);
        return $this->fetch();
    }
    //优惠卷
    public function good_coupon(){

    }

}
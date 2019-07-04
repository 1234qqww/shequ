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
    //首页背景
    public function banner(){
        if(request()->isAjax()){
            $file=$_SERVER['DOCUMENT_ROOT'].'/../application/extra/'.$_POST['configname'].'.php';
            if(!file_exists($file)){
                return $this->error('模板不存在!');
            }
           $param=$this->request->param();
            if (empty($param['bannerimg'])) {
                return $this->error('请上传图片!');
            }
            if (strlen($param['bannerimg'])>100) {
                $param['bannerimg'] = base64toimg($param['bannerimg']);
            }
            unset($param['configname']);
            $str="<?php \r\n return [ \r\n";
            foreach ($param as $k => $v) {
                if(is_array($v)){
                    $str.="'".$k."'=>[";
                    foreach($v as $a=>$b){
                        $str.="'".$a."'=>'".$b."',";
                    }
                    $str.="],";
                }else{
                    $str.="'".$k."'=>'".$v."',\r\n";
                }
            }
            $str.="];\r\n ?>";
            if(fwrite(fopen($file,'w'), $str)){
                return $this->success('保存成功!');
            }else{
                return $this->error('保存失败!');
            }
        }
        return  $this->fetch();
    }


    //专线广告
    public function zhuanxian(){
        if(request()->isAjax()){
            $file=$_SERVER['DOCUMENT_ROOT'].'/../application/extra/'.$_POST['configname'].'.php';
            if(!file_exists($file)){
                return $this->error('模板不存在!');
            }
            $param=$this->request->param();
            if (empty($param['bannerimg'])) {
                return $this->error('请上传图片!');
            }
            if (strlen($param['bannerimg'])>100) {
                $param['bannerimg'] = base64toimg($param['bannerimg']);
            }
            unset($param['configname']);
            $str="<?php \r\n return [ \r\n";
            foreach ($param as $k => $v) {
                if(is_array($v)){
                    $str.="'".$k."'=>[";
                    foreach($v as $a=>$b){
                        $str.="'".$a."'=>'".$b."',";
                    }
                    $str.="],";
                }else{
                    $str.="'".$k."'=>'".$v."',\r\n";
                }
            }
            $str.="];\r\n ?>";
            if(fwrite(fopen($file,'w'), $str)){
                return $this->success('保存成功!');
            }else{
                return $this->error('保存失败!');
            }
        }
    }

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
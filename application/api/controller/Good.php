<?php


namespace app\api\controller;


use think\Db;

class Good extends Base
{
    //商户申请状态查询
    public function good_index(){
        $param=$this->request->param();
        unset($param['token']);
        $good=model('good')->good_index($param);
        if(!$good){
            return json(array('code'=>1,'msg'=>'未申请'));
        }
        if($good['state']==1){
            return json(array('code'=>2,'msg'=>'审核中'));
        }
        if($good['state']==3){
            return json(array('code'=>3,'msg'=>'审核通过'));
        }
    }

    //商户账号查询
    public function good_admin(){
        $param=$this->request->param();
        unset($param['token']);
        $good=model('good')->good_admin($param);
        if(!$good){
            return json(array('code'=>0,'msg'=>'查询失败'));
        }
        return json(array('code'=>1,'msg'=>'查询成功','data'=>$good));
    }



    //图片上传
    public function good_upload(){
        $file = $this->request->file('file');
        $photo = '';
        if (!empty($file)) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['size' =>1024*1024*10, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            $error = $file->getError();
            //验证文件后缀后大小
            if (!empty($error)) {
                return  json(array('code'=>0,'msg'=>'图片上传失败'));
            }
            if ($info) {
                //获取上传问文件名
                $photo = $info->getSaveName();
                if ($photo !== '') {
                    return  json(array('code'=>1,'msg'=>'成功','data'=>'/uploads/'.$photo));
                } else {
                    return json(self::showReturnCode(2, null, "上传失败"));
                }
            }else {
                return json(self::showReturnCode(404, null, "图片上传失败"));
            }
        }
    }


    //商户入驻申请
    public function good_add(){
        $param=$this->request->param();
        unset($param['token']);
        if(!preg_match("/^1[345678]{1}\d{9}$/",$param['tel'])){
            return json(array('code'=>0,'msg'=>'请输入正确的手机号码'));
        }
        $good=model('good')->good_add($param);
        if(!$good){
            return json(array('code'=>0,'msg'=>'添加失败'));
        }
        return json(array('code'=>1,'msg'=>'添加成功'));
    }
}
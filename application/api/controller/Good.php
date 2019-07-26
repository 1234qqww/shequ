<?php


namespace app\api\controller;


use think\Config;
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

    //商家店面
    public function good_main(){
        $param=$this->request->param();
        unset($param['token']);
        $url=Config::get('host');
        $page=$param['page'];
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        $where['store_count']= array('gt',0);
        $where['state']= 1;
        $where['is_show']=1;
        $where['good_id']=$param['id'];
        $where['prom_type']=0;
        $order='';
        if($param['listnum']==3){
            $where['is_tuijian']=1;   //商品展示推荐商品
        }elseif ($param['listnum']==0){
            $where['is_newshop']=1;  //最新商品
        }elseif($param['listnum']==1){
            $order='shop_price asc';
        }elseif ($param['listnum']==2){
            $order='sales_sum desc';
        }
        $goods=model('goods')->selectAll($where,$page,$order);
        if($param['id']!=-1){
            $field='id,name,tel,pic,pic_bg';
            $good=model('good')->getFind($field,['id'=>$param['id']]);

            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/", $good['pic'])){
                $good['pic']=$url['url']. $good['pic'];
            }
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$good['pic_bg'])){
                $good['pic_bg']=$url['url'].$good['pic_bg'];
            }
        }else{
            $base_congif=Config::get('base_config');
            $good['name']='平台自营';
            $good['pic']=$base_congif['imgs'];
            $good['pic_bg']=$base_congif['pic_bg'];
            $good['tel']=$base_congif['service_number'];
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$base_congif['imgs'])){
                $good['pic']=$url['url'].$base_congif['imgs'];
            }
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$base_congif['pic_bg'])){
                $good['pic_bg']=$url['url'].$base_congif['pic_bg'];
            }
        }
        $arr=array('goods'=>$goods,'good'=>$good);
        return  json(array('code'=>1,'msg'=>'成功','data'=>$arr));
    }




}
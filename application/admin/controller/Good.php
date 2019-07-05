<?php


namespace app\admin\controller;


use app\common\model\Txapi;
use think\Db;

class Good extends Base
{
    //商户入驻审核列表
    public function good_listadd(){
            if(request()->isAjax()){
                $get=input();
                $where=array('state'=>1);
                if(isset($get['name']) && $get['name']!=''){
                    $where['name']=array('like','%'.$get['name'].'%');
                }
                if(isset($get['contacts']) && $get['contacts']!=''){
                    $where['contacts']=array('like','%'.$get['contacts'].'%');
                }

                if(isset($get['phone']) && $get['phone']!=''){
                    $where['tel']=array('like','%'.$get['tel'].'%');
                }
                return   Db::name('good')->where($where)->order('date desc')->paginate(15);
            }

        return $this->fetch();
    }


    //商户审核通过
    public function good_add(){
        if(request()->isAjax()){
            $param=$this->request->param();
            $data['username']=$param['username'];
            $data['role_id']=6;
            $data['goodid']=$param['id'];
            $data['password']=$param['password'];
            $data['pass']=$param['password'];
            $admin=model("admin")->add_admin($data);
            if($admin['code']!=1){
                return json(['code'=>0,'msg'=>$admin['msg']]);
            }
            $good['state']=3;
            $good['goodAdmin']=$admin['data'];
            $txapi=new Txapi();
            $a=$txapi->coordinate($param['address']);
            $good['lng']=$a->lng;//经度
            $good['lat']=$a->lat;//纬度
           if(Db::name('good')->where(['id'=>$param['id']])->data($good)->update()){  //修改审核状态增加经纬度用户账号
               return json(['code'=>1,'msg'=>'审核成功']);
           }
            return json(['code'=>0,'msg'=>'审核失败']);
        }
       $data=model('good')->good_add(input());
        $this->assign([
            'data'=>$data
        ]);
        return $this->fetch();

    }
    //商户驳回
    public function del_good(){
        if(Db::name('good')->where(input())->delete()){
            return json(['code'=>1,'msg'=>'驳回成功']);
        }
        return json(['code'=>0,'msg'=>'驳回失败']);
    }
    //商户列表

    public function good(){
       if(request()->isAjax()){
           $get=input();
           $where=array('state'=>3);
           if(isset($get['name']) && $get['name']!=''){
               $where['name']=array('like','%'.$get['name'].'%');
           }
           $data=Db::name('good')->where($where)->order('date desc')->select();
           $this->assign([
               'data'=>$data
           ]);
            return $this->fetch();
       }
        $data=Db::name('good')->where(['state'=>3])->order('date desc')->select();
        $this->assign([
            'data'=>$data
        ]);
        return $this->fetch();
    }


    //后台添加商户
    public function good_adds(){
        if(request()->isAjax()){
            $param=$this->request->param();
            if(!preg_match("/^1[345678]{1}\d{9}$/",$param['tel'])){
                return json(array('code'=>0,'msg'=>'请输入正确的手机号码'));
            }
            if(!isset($param['pic'])){
                return json(['code'=>0,null,'msg'=>"请上传商户头像"]);
            }
            if(strpos($param['pic'],'base64') !== false){
                $param['pic']=base64toimg($param['pic']);
            }
            if(!isset($param['pic_bg'])){
                return json(['code'=>0,null,'msg'=>"请上传商户背景图"]);
            }
            if(strpos($param['pic_bg'],'base64') !== false){
                $param['pic_bg']=base64toimg($param['pic_bg']);
            }
           $param['state']=3;  //审核通过
//            $good['goodAdmin']=$admin['data'];
            $txapi=new Txapi();
            $a=$txapi->coordinate($param['address']);
            $param['lng']=$a->lng;//经度
            $param['lat']=$a->lat;//纬度
            $data['username']=$param['username'];
            $data['password']=$param['password'];
            $data['pass']=$param['password'];
            unset($param['username']);
            unset($param['password']);
            $good=model('good')->good_adds($param);
            $data['role_id']=6;
            $data['goodid']=$good;

            $admin=model("admin")->add_admin($data);
            if($admin['code']!=1){
                return json(['code'=>0,'msg'=>$admin['msg']]);
            }
           if(!Db::name('good')->where(['id'=>$good])->data(['goodAdmin'=>$admin['data']])->update()){
               return json(['code'=>0,'msg'=>'添加失败']);
           }
            return json(['code'=>1,'msg'=>'添加成功']);

        }
        return $this->fetch();
    }

    //修改信息
    public function good_edit(){
        if(request()->isAjax()){
            $param=$this->request->param();
            if(!preg_match("/^1[345678]{1}\d{9}$/",$param['tel'])){
                return json(array('code'=>0,'msg'=>'请输入正确的手机号码'));
            }
            if(!isset($param['pic'])){
                return json(['code'=>0,null,'msg'=>"请上传商户头像"]);
            }
            if(strpos($param['pic'],'base64') !== false){
                $param['pic']=base64toimg($param['pic']);
            }
            if(!isset($param['pic_bg'])){
                return json(['code'=>0,null,'msg'=>"请上传商户背景图"]);
            }
            if(strpos($param['pic_bg'],'base64') !== false){
                $param['pic_bg']=base64toimg($param['pic_bg']);
            }
            $txapi=new Txapi();
            $a=$txapi->coordinate($param['address']);
            $param['lng']=$a->lng;//经度
            $param['lat']=$a->lat;//纬度
            $data['password']=$param['pass'];
            $data['pass']=$param['pass'];
            $data['goodid']=$param['id'];
            unset($param['username']);
            unset($param['pass']);
            Db::name('good')->where(['id'=>$param['id']])->data($param)->update();   //修改商户信息
            $admin=model('admin')->edit_admins($data);                          //修改商家账户密码
            if ($admin['code']!=1){
                return json(array('code'=>0,'msg'=>$admin['msg']));
            }
            return json(array('code'=>1,'msg'=>'修改成功'));
        }

        $param=$this->request->param();
        $good=Db::name('good')->where(['id'=>$param['id']])->find();
        $admin=Db::name('admin')->where(['goodid'=>$param['id']])->find();
        $this->assign([
           'good'=>$good,
           'admin'=>$admin
        ]);
        return $this->fetch();
    }





}
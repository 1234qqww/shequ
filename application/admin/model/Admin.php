<?php

namespace app\admin\model;

use app\common\model\common;
use think\Db;
class Admin extends Common {
    //登录
    public function admin_login(array $data){
        $admin=Db::name('admin')->where(array('username'=>$data['username']))->find();
        if(!$admin || $admin['password']!=hhtc_encrypt($data['password'])){
            return $this->error('用户或密码错误!');
        }
        if($admin['password']!=hhtc_encrypt($data['password'])){
            admin_log('登录密码错误!',$admin['admin_id']);
            return $this->error('用户或密码错误!');
        }
        admin_log('登录成功!',$admin['admin_id']);
        unset($admin['password']);
        session('admin',$admin);
        session('admin_id',$admin['admin_id']);
        //更新用户信息
        $admin['last_login_ip']=$_SERVER['REMOTE_ADDR'];
        $admin['last_login_time']=date('Y-m-d H:i:s');
        Db::name('admin')->update($admin);
//        $this->check_role($admin);
        return $this->success('登入成功!');
    }
    //缓存操作权限
    public function check_role($admin){
        //查看管理员权限
        $ids=Db::name('role')->where(array('role_id'=>$admin['role_id']))->value('ids');

        $ids=json_decode($ids,true);
        $ids=implode(',',$ids);
        //查看所有的菜单
        $menus=Db::name('menu')->where(array('menu_id'=>array('in',$ids)))->select();
        $allow=array();
        //所有人都允许
        $allow['index'][]='index';
        $allow['home'][]='edit_pwd';
        foreach($menus as $k=>$v){
            $allow[strtolower($v['controller'])][]=$v['action'];
        }
        $common=public_functions();
        foreach($allow as $k=>$v){
            foreach ($v as $a => $b) {
                if(isset($common[$k.'-'.$b]) && !empty($common[$k.'-'.$b])){
                    foreach($common[$k.'-'.$b] as $c=>$d){
                        $allow[$k][]=$d;
                    }
                }
            }
        }

        session('allow_menu',$allow);
    }
    //权限检测
    public function check_menu($controller,$action){
        $allow=session('allow_menu');
        if(!isset($allow[$controller]) || !in_array($action,$allow[$controller])){
            return false;
        }

        return true;
    }
    //添加管理员
	public function add_admin(array $data){
	    if($data['role_id']==0){
	        return $this->error('请选择管理员角色');
        }
	    if(strlen($data['username'])>100){
	        return $this->error('用户名过长');
        }
        if(strlen($data['password'])<6 || strlen($data['password'])>12){
            return $this->error('密码为6~12位');
        }
	    if(Db::name('admin')->where(array('username'=>$data['username']))->find()){
            return $this->error('用户名已存在!');
        }
        $data['password']=hhtc_encrypt($data['password']);
	    $data['atime']=date("Y-m-d H:i:s");
	    $id=Db::name('admin')->insertGetId($data);
        if($id){
            return ['code'=>1,'msg'=>'成功','data'=>$id];
        }
        return $this->error('添加失败!');
    }

    //编辑管理员
    public function edit_admin(array $data){
	    if(isset($data['password']) && $data['password']!=''){
	        if(strlen($data['password'])<6 || strlen($data['password'])>12){
	            return $this->error('登录密码为6-12位!');
            }
            $upd['password']=hhtc_encrypt($data['password']);
        }
        $upd['admin_id']=$data['admin_id'];
	    $upd['role_id']=$data['role_id'];
	    if(Db::name('admin')->update($upd)){
	        return $this->success('操作成功!');
        }else{
	        return $this->error('没有改动!');
        }

    }
    //删除管理员
    public function del_admin(array $data){
	    if($data['admin_id']==session('admin_id')){
	        return $this->error('不能删除自己!');
        }
        if(Db::name('admin')->delete($data)){
	        return $this->success('删除成功!');
        }else{
            return $this->error('删除失败!');
        }
    }
    //管理员数据
    public function admin_list(array $data){
	    switch ($data['action']){
            case  'paginate':
                return Db::name('admin')
                        ->alias('a')
                        ->join('role b','a.role_id=b.role_id')
                        ->field($data['field'])
                        ->where($data['where'])
                        ->order('atime desc')
                        ->paginate();
                break;
            case 'find':
                return Db::name('admin')
                    ->alias('a')
                    ->join('role b','a.role_id=b.role_id')
                    ->field($data['field'])
                    ->where($data['where'])
                    ->order('atime desc')
                    ->find();
                break;
            case 'select':
                return Db::name('admin')
                    ->alias('a')
                    ->join('role b','a.role_id=b.role_id')
                    ->field($data['field'])
                    ->where($data['where'])
                    ->order('atime desc')
                    ->select();
                break;
            default:
                return $this->error('无效操作!');
        }
    }
    //角色数据
    public function get_role_list(array $data){
        switch ($data['action']){
            case 'paginate':
                return Db::name('role')->where($data['where'])->order('atime descc')->paginate();
                break;
            case 'find':
                return Db::name('role')->where($data['where'])->order('atime descc')->find();
                break;
            case 'select':
                return Db::name('role')->where($data['where'])->order('atime descc')->select();
                break;
            default:
                return $this->error('无效操作!');
        }
    }
    public function add_role(array $data){
        $ids=array();
        if(!isset($data['limits'])){
            return $this->error("请选择操作权限!");
        }
        foreach($data['limits'] as $k=>$v){
            if(!in_array($k,$ids)){
                $ids[]=$k;
            }
            if(is_array($v)){
                foreach($v as $a=>$b){
                    if(!in_array($a,$ids)){
                        $ids[]=$a;
                    }
                    if(is_array($b)){
                        foreach($b as $s=>$ss){
                            if(!in_array($s,$ids)){
                                $ids[]=$s;
                            }
                        }
                    }
                }
            }
        }
        $ins['role_name']=$data['role_name'];
        $ins['ids']=json_encode($ids);
        $ins['describe']=$data['describe'];
        $ins['atime']=date('Y-m-d H:i:s');
        if(Db::name('role')->insert($ins)){
            return $this->success('添加成功!');
        }else{
            return $this->error('添加失败!');
        }
    }
    //编辑角色
    public function edit_role(array $data){
        $ids=array();
        if(!isset($data['limits'])){
            return $this->error("请选择操作权限!");
        }
        foreach($data['limits'] as $k=>$v){
            if(!in_array($k,$ids)){
                $ids[]=$k;
            }
            if(is_array($v)){
                foreach($v as $a=>$b){
                    if(!in_array($a,$ids)){
                        $ids[]=$a;
                    }
                    if(is_array($b)){
                        foreach($b as $s=>$ss){
                            if(!in_array($s,$ids)){
                                $ids[]=$s;
                            }
                        }
                    }
                }
            }
        }
        $upd['role_id']=$data['role_id'];
        $upd['role_name']=$data['role_name'];
        $upd['describe']=$data['describe'];
        $upd['ids']=json_encode($ids);
        if(Db::name('role')->update($upd)){
            return $this->success('保存成功!');
        }else{
            return $this->error('没有改动!');
        }
    }
    //删除角色
    public function del_role(array $data){
        if(Db::name('admin')->where(array('role_id'=>$data['role_id']))->find()){
            return $this->error('该角色下存在管理员!请先删除管理员!');
        }
        if(Db::name('role')->delete($data)){
            return $this->success('删除成功!');
        }else{
            return $this->error('删除失败!');
        }
    }
    //修改密码
    public function edit_pwd(array $data){
        $admin=Db::name('admin')->where(array('admin_id'=>session('admin_id')))->find();
        if($admin['password']!=hhtc_encrypt($data['oldPassword'])){
            return $this->error('原密码错误!');
        }
        $upd['admin_id']=session('admin_id');
        $upd['password']=hhtc_encrypt($data['password']);
        if(Db::name('admin')->update($upd)){
            return $this->success('修改成功!');
        }else{
            return $this->error('修改失败!');
        }
    }


    //修改密码
    public function edit_admins($data){
        if(strlen($data['password'])<6 || strlen($data['password'])>12){
            return $this->error('密码为6~12位');
        }
        $data['password']=hhtc_encrypt($data['password']);
        Db::name('admin')->where(['goodid'=>$data['goodid']])->update($data);
        return $this->success('修改成功!');

    }

}
?>
<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Admin extends Base
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        //获取角色
        $data['where']=array();
        $data['action']='select';
        $roles=model('admin')->get_role_list($data);
        $this->assign('roles',$roles);
    	return $this->fetch();
    }

    public function index_data(){
        $get=input();
        $where=array();
        if(isset($get['username']) && $get['username']!=''){
            $where['username']=$get['username'];
        }
        if(isset($get['role_id']) && $get['role_id']!=''){
            $where['a.role_id']=$get['role_id'];
        }
        if(isset($get['time']) && $get['time']!=''){
            $times=explode(' - ',$get['time']);
            $where['atime']=array('between',array($times[0].' 00:00:00',$times[1]." 23:59:59"));
        }
        $data['where']=$where;
        $data['action']='paginate';
        $data['field']='a.*,b.role_name';
        return json(model('admin')->admin_list($data));
    }

    //添加管理员
    public function add_admin(){
        if(request()->isAjax()){
            return json(model("admin")->add_admin(input()));
        }
        //获取角色
        $data['where']=array();
        $data['action']='select';
        $roles=model('admin')->get_role_list($data);
        $this->assign('roles',$roles);
        return $this->fetch();
    }
    //编辑管理员
    public function edit_admin(){
        if(request()->isAjax()){
            return json(model("admin")->edit_admin(input()));
        }
        //获取角色
        $data['where']=array();
        $data['action']='select';
        $roles=model('admin')->get_role_list($data);
        $this->assign('roles',$roles);
        $data=array();
        $data['where']=array('admin_id'=>input('param.admin_id'));
        $data['action']='find';
        $data['field']='a.*';
        $this->assign('info',model('admin')->admin_list($data));
        return $this->fetch();
    }
    //删除管理员
    public function del_admin(){
        if(request()->isAjax()){
            return model('admin')->del_admin(input());
        }
    }
    //批量删除管理员
    public function del_admin_pl(){
        if(request()->isAjax()){
            $data=input();
            $data['admin_ids']=rtrim($data['admin_ids'],',');
           $ids=explode(',',$data['admin_ids']);
           $msg='';
           $check=false;
           foreach($ids as $k=>$v){
                $data['admin_id']=$v;
                $res=model('admin')->del_admin($data);
                if($res['code']==0){
                    $msg.='ID:'.$v.'删除失败！原因:'.$res['msg'].'<br>';
                }else{
                    $check=true;
                }
           }
           if($msg==''){
               $res['code']=1;
               $res['msg']='删除成功!';
           }else{
               $res['code']=0;
               $res['msg']=$msg;
           }
           return json($res);
        }
    }
    //角色列表
    public function role(){
        return $this->fetch();
    }
    public function role_data(){
        $get=input();
        $where=array();
        $data['where']=$where;
        $data['action']='paginate';
        return(model('admin')->get_role_list($data));
    }
    //删除角色
    public function del_role(){
        return model('admin')->del_role(input());
    }
    //添加角色
    public function add_role(){
        if(request()->isAjax()){
            return model('admin')->add_role(input());
        }
        //获取所有菜单
        $menus=model('menu')->get_menus_role();
        $this->assign('menus',$menus);
        return $this->fetch();
    }
    //编辑角色
    public function edit_role(){
        if(request()->isAjax()){
            return model('admin')->edit_role(input());
        }
        $data['where']=array('role_id'=>input('param.role_id'));
        $data['action']='find';
        $role=model('admin')->get_role_list($data);
        $role['ids']=json_decode($role['ids'],true);
        $this->assign('role',$role);
        //获取所有菜单
        $menus=model('menu')->get_menus_role();
        $this->assign('menus',$menus);
        return $this->fetch();
    }
}

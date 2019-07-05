<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
class Home extends Base
{
    public function _initialize(){
        parent::_initialize();

    }
    public function welcome()
    {
    	return $this->fetch();
    }
    //菜单
    public function menu(){
        return $this->fetch();
    }
    //添加菜单
    public function add_menu(){
        if(request()->isAjax()){
            return model('menu')->add_menu(input());
        }
        return $this->fetch();
    }
    public function menu_data(){
        $get=input();
        $where=array();
        if(isset($get['level']) && $get['level']!=''){
            $where['level']=$get['level'];
        }
        if(isset($get['pid']) &&$get['pid']!=''){
            $where['pid']=$get['pid'];
        }
        $data['where']=$where;
        $data['action']=isset($get['action'])?$get['action']:'paginate';
        return json(model('menu')->get_menu($data));
    }
    //编辑菜单
    public function edit_menu(){
        if(request()->isAjax()){
            return model('menu')->edit_menu(input());
        }
        $where['menu_id']=input('param.menu_id');
        $data['where']=$where;
        $data['action']='find';
        $info=model('menu')->get_menu($data);
        if($info['level']==3){
            $info['ppid']=Db::name('menu')->where(array('menu_id'=>$info['pid']))->value('pid');
        }else{
            $info['ppid']=0;
        }
        $this->assign('info',$info);
        return $this->fetch();
    }
    //删除菜单
    public function del_menu(){
        if(request()->isAjax()){
            return model('menu')->del_menu(input());
        }
    }
    //修改密码
    public function edit_pwd(){
        if(request()->isAjax()){
            return model('admin')->edit_pwd(input());
        }
        return $this->fetch();
    }
        //退出登录
    public function login_out(){
        session('admin',null);
        if(!session('admin')){
              return ['code'=>1];
        }
    }
}

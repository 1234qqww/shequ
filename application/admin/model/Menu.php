<?php

namespace app\admin\model;

use app\common\model\common;
use think\Db;
class Menu extends Common {
	public function get_menu(array $data){
	    switch($data['action']){
            case 'paginate':
                return Db::name('menu')->where($data['where'])->order('sort asc')->paginate();
                break;
            case 'find':
                return Db::name('menu')->where($data['where'])->order('sort asc')->find();
                break;
            case 'select':
                return Db::name('menu')->where($data['where'])->order('sort asc')->select();
                break;
            default:
                return $this->error('无效操作！');
        }
    }

    public function add_menu(array $data){
	    if($data['level']=='1'){
	        $ins['pid']=0;
	        $ins['level']=1;
	        $ins['icon']=$data['icon'];
	        if($ins['icon']==''){
	            return $this->error('请输入字体图标');
            }
        }
        if($data['level']==2){
	        if($data['menu_one']==0){
	            return $this->error('请选择所属一级菜单');
            }
            $ins['pid']=$data['menu_one'];
            $ins['level']=2;
        }
        if($data['level']==3){
            if($data['menu_two']==0){
                return $this->error('请选择所属二级菜单');
            }
            $ins['pid']=$data['menu_two'];
            $ins['level']=3;
        }
        if(isset($data['display'])){
            $ins['display']=1;
        }else{
           $ins['display']=0;
        }
        $ins['name']=$data['name'];
        $ins['controller']=$data['controller'];
        $ins['action']=$data['action'];
        $ins['sort']=$data['sort'];
        Db::name('menu')->insert($ins);
        return $this->success('添加成功!');
    }
    //加载所有显示状态菜单
    public function get_menus(){
        //获取可以操作的菜单id
        $admin=session('admin');
        //查询管理权限id
        $ids=Db::name('role')->where(array('role_id'=>$admin['role_id']))->value('ids');
        //转换json数据为数组
        $ids=json_decode($ids,true);
        //数值转为字符串
        $ids=implode(',',$ids);
        $where1['display']=1;
        $where1['pid']=0;
        $where1['menu_id']=array('in',$ids);
        //查询出左侧导航条主菜单
        $menus=Db::name('menu')->where($where1)->order('sort asc')->select();
        foreach($menus as $k=>$v){
            $where2['display']=1;
            $where2['pid']=$v['menu_id'];
            $where2['menu_id']=array('in',$ids);
            //判断主菜单查询出子菜单
            $menu2=Db::name('menu')->where($where2)->order('sort asc')->select();
            if(!empty($menus)){
                foreach($menu2 as $a=>$b){
                    $where3['display']=1;
                    $where3['pid']=$b['menu_id'];
                    $where3['menu_id']=array('in',$ids);
                    //根据子菜单查询出子菜单的子菜单
                    $menu2[$a]['sons']=Db::name('menu')->where($where3)->order('sort asc')->select();
                }
            }
            $menus[$k]['sons']=$menu2;
        }
        return $menus;
    }
    //编辑菜单
    public function edit_menu(array $data){
        $upd['menu_id']=$data['menu_id'];
        $upd['level']=$data['level'];
        if($data['level']==1){
            $upd['pid']=0;
            $upd['icon']=$data['icon'];
            if($upd['icon']==''){
                return $this->error('请输入字体图标');
            }
        }else{
            $upd['icon']='';
        }
        if($data['level']==2){
            if($data['menu_one']==0){
                return $this->error('请选择所属一级菜单');
            }
            $upd['pid']=$data['menu_one'];
        }
        if($data['level']==3){
            if($data['menu_two']==0){
                return $this->error('请选择所属二级菜单');
            }
            $upd['pid']=$data['menu_two'];
        }
        if(isset($data['display'])){
            $upd['display']=1;
        }else{
            $upd['display']=0;
        }
        $upd['name']=$data['name'];
        $upd['controller']=$data['controller'];
        $upd['action']=$data['action'];
        Db::name('menu')->update($upd);
        return $this->success('保存成功!');
    }
    public function del_menu(array $data){
        if(Db::name('menu')->where(array('pid'=>$data['menu_id']))->find()){
            return $this->error('该菜单存在子菜单无法删除!');
        }
        if(Db::name('menu')->delete($data)){
            return $this->success('删除成功!');
        }else{
            return $this->error('删除失败!');
        }
    }
    public function get_menus_role(){
        $where['pid']=0;
        $menus=Db::name('menu')->where($where)->order('sort asc')->select();
        foreach($menus as $k=>$v){
            $menuss=Db::name('menu')->where(array('pid'=>$v['menu_id']))->order('sort asc')->select();
            if(!empty($menus)){
                foreach($menuss as $a=>$b){
                    $menuss[$a]['sons']=Db::name('menu')->where(array('pid'=>$b['menu_id']))->order('sort asc')->select();
                }
            }
            $menus[$k]['sons']=$menuss;
        }
        return $menus;
    }
}
?>
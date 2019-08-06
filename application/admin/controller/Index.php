<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Index extends Base
{
    public function _initialize(){
        parent::_initialize();
        header('Content-type:text/html;charset=utf-8');
        //初始化
        /*if(!session('admin')){
            $this->redirect('Login/login');
        }*/
    }
    public function index()
    {
    	return $this->fetch(":index");
    }
    public function indexs()
    {
        $admin=session('admin');  //登录账号
        $admin['goodid'];
        $good=Db::name('good')->where(['id'=>$admin['goodid']])->find();   //商铺
        session('good',$good['id']);
        $this->assign([
           'admin'=>$admin,
           'good'=>$good
        ]);
        return $this->fetch(":indexs");
    }
    //跳转商铺
    public function goodindexs(){
        $param=$this->request->param();
        $good=Db::name('good')->where(['id'=>$param['id']])->find();//商铺
        $admin=Db::name('admin')->where(['goodid'=>$param['id']])->find(); //登录账号
        session('good',$good['id']);
        $this->assign([
            'admin'=>$admin,
            'good'=>$good
        ]);
        return $this->fetch(":indexs");
    }
    public function gs(){
        $param = $this->request->param();

        if (is_numeric($param['merchantid']) ||  $param['merchantid']=='indexs') {

            if(is_numeric($param['merchantid'])){
                session('merchantid', $param['merchantid']);
            }else{
                session('merchantid', session('good'));
            }
        } else {
            session('merchantid', -1);
        }
    }

}

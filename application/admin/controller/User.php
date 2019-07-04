<?php


namespace app\admin\controller;


use think\Db;

class User extends Base
{

    public function user(){
        if(request()->isAjax()){
            $get=input();
            $where=array();
            if(isset($get['userName']) && $get['userName']!=''){
                $where['userName']=array('like','%'.$get['userName'].'%');
            }

          return  Db::name('user')->where($where)->order('atime desc')->paginate(15);

        }


        return $this->fetch();
    }

}
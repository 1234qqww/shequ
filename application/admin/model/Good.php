<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class Good extends Model
{

    //商户审核通过
    public function good_add($data){


      return  Db::name('good')->where($data)->find();


    }

    //后台添加商户
    public function good_adds($data){
        return    Db::name('good')->insertGetId($data);
    }





}
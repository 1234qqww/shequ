<?php


namespace app\api\model;


use app\api\controller\Base;
use think\Db;

class GoodCategory extends Base
{
    public function selectTuiJianAll(){

   return    Db::name('good_category')->where(['is_tuijian'=>1,'is_show'=>1])->order('level,sort_order asc')->select();

    }


}
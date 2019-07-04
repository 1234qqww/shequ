<?php


namespace app\admin\model;


use app\admin\controller\Base;
use think\Db;

class Goods extends Base
{
    public function goods($where){

      return Db::name('goods')->where($where)->order('sort desc')->paginate(15);


    }

}
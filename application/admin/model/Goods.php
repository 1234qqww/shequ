<?php


namespace app\admin\model;


use app\admin\controller\Base;
use think\Db;

class Goods extends Base
{
<<<<<<< HEAD
    public function goods($where){

      return Db::name('goods')->where($where)->order('sort desc')->paginate(15);


    }

=======
    //商品列表
    public function goods($where){
      return Db::name('goods')->where($where)->order('sort desc')->paginate(15);
    }

    //添加商品
    public function goods_add($data){

    return   Db::name('goods')->insertGetId($data);

    }


>>>>>>> ab434a71ae2085e5543b36f584c9ca6c557ef2d7
}
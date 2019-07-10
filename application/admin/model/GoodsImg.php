<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class GoodsImg extends Model
{

        public function getSelectAll($where,$aut){
            Db::name('goods_img')->where(['goods_id'=>$where])->delete();




            return   Db::name('goods_img')->insertAll($aut);

        }



}
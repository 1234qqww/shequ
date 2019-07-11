<?php


namespace app\api\model;


use think\Db;
use think\Model;

class Slide extends Model
{
    public function selectPosition($position){
     return   Db::name('slide')->where(['position'=>$position,'display'=>1])->order('order asc')->select();
    }

}
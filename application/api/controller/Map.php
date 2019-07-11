<?php


namespace app\api\controller;


use app\common\model\Txapi;
use think\Config;
use think\Controller;
use think\Db;
use think\db\Expression;

class Map extends Controller
{
    //通过经纬度返回距离
    public function map(){
       $param=$this->request->param();
       $latitude=$param['latitude'];      //用户实时纬度
       $longitude=$param['longitude'];   //用户实时经度
        $list=Db::name('merchant')->field('mername,merportrait,prov,city,area,address,lng,lat,mobile,setout,arrive,id')->select();
        if (!$list){
            echo json_encode(array('code'=>0,'msg'=>'暂无数据','data'=>$list));
        }
         $txapi=new Txapi();
         foreach ($list as $k=>$v){
           $list[$k]['juli']=number_format($txapi->getJuli($latitude,$longitude,$v['lat'],$v['lng']),1);
         }
        $flag=array();
        foreach($list as $arr2){
            $flag[]=$arr2["juli"];
        }
        array_multisort($flag, SORT_ASC, $list);
        return json(array('code'=>1,'msg'=>'操作成功','data'=>$list));
    }


    //测试
//    public function ceshi(){
//        $txapi=new Txapi();
//       $a=$txapi->getJuli(30.69015,104.05293,30.6776610,104.1465080);
//       dump($a);die();
//    }

}
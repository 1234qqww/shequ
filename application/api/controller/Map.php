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


    //查询商户详情
    public function details(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        Db::name('merchant')->where(['id'=>$param['id']])->setInc('number');
        $merchant=Db::name('merchant')->where(['id'=>$param['id']])->find();
        $merchant['route']=json_decode($merchant['route'],true);
        $authent=Db::name('authent')->where(['merid'=>$param['id']])->select();
        $fact=Db::name('fact')->where(['merid'=>$param['id']])->select();
        $collection=Db::name('collection')->where(['userid'=>$param['userid'],'merid'=>$param['id'],'state'=>2])->select(); //收藏商家
             $state=1;  //未收藏
        if($collection){
            $state=2;  //收藏
        }
        $banner_config=Config::get('banner_config');
        $historical=Db::name('historical')->where(['userid'=>$param['userid'],'merid'=>$param['id']])->find();
        if(!$historical){
            $arr['userid']=$param['userid'];
            $arr['merid']=$param['id'];
            $arr['atime']=date('Y-m-d H:i:s');
            $arr['state']=2;  //公司
            Db::name('historical')->insert($arr);
        }

        Db::name('historical')->where(['id'=>$historical['id']])->update(['atime'=>date('Y-m-d H:i:s')]);

        $data=array('merchant'=>$merchant,'authent'=>$authent,'fact'=>$fact,'banner'=>$banner_config['bannerimg'],'state'=>$state);

        return  json(array('code'=>1,'data'=>$data));

    }

    //模糊查询公司
    public function mermap(){
        $param=$this->request->param();
        $latitude=$param['latitude'];      //用户实时纬度
        $longitude=$param['longitude'];   //用户实时经度
        $where=array('like','%'.$param['mername'].'%');
        $list=Db::name('merchant')->where(['mername'=>$where])->field('mername,merportrait,prov,city,area,address,lng,lat,mobile,setout,arrive,id')->select();
        if(!$list){
            return  json(array('code'=>2,'msg'=>'暂无数据'));
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
        return json(array('code'=>1,'msg'=>'成功','data'=>$list));
    }

    //专线查询

    public function zhuanxian(){
        $param=$this->request->param();
        $latitude=$param['latitude'];      //用户实时纬度
        $longitude=$param['longitude'];   //用户实时经度
        $string1=str_replace("省","",$param['setout']);
        $string1=str_replace("市","",$string1);
        $string1=str_replace("区","",$string1);
        $string2=str_replace("省","",$param['arrive']);
        $string2=str_replace("市","",$string2);
        $string2=str_replace("区","",$string2);
        $list=Db::name('merchant')->where(['setout'=>$string1,'arrive'=>$string2])->field('mername,merportrait,prov,city,area,address,lng,lat,mobile,setout,arrive,id')->select();
        if(!$list){
            return  json(array('code'=>2,'msg'=>'暂无数据'));
        }
        $txapi=new Txapi();
        $a = array();
        foreach ($list as $k=>$v){
            $list[$k]['juli']=number_format($txapi->getJuli($latitude,$longitude,$v['lat'],$v['lng']),1); //保留小数点后一位
        }

        $flag=array();
        foreach($list as $arr2){
            $flag[]=$arr2["juli"];
        }
        array_multisort($flag, SORT_ASC, $list);
        $banner_config=Config::get('zhuanxian_config');
        $array=array('list'=>$list,'banner'=>$banner_config['bannerimg']);
        return json(array('code'=>1,'msg'=>'成功','data'=>$array));
    }
    //专线详情
    public function zxxiangqin(){
        $param=$this->request->param();
        if(!$param['userid']){
            return  json(array('code'=>0,'msg'=>'非法操作'));
        }
        Db::name('merchant')->where(['id'=>$param['id']])->setInc('number');   //预览量加一
        $merchant=Db::name('merchant')->where(['id'=>$param['id']])->find();           //查询该商户的详情
        $collection=Db::name('collection')->where(['userid'=>$param['userid'],'merid'=>$param['id'],'state'=>1])->select(); //查询该用户是否收藏了该直达路线
            $state=1;  //未收藏
        if($collection){
            $state=2;  //收藏
        }
        $historical=Db::name('historical')->where(['userid'=>$param['userid'],'merid'=>$param['id']])->find();   //查询有没有该条浏览记录
        if(!$historical){
            $arr['userid']=$param['userid'];
            $arr['merid']=$param['id'];
            $arr['atime']=date('Y-m-d H:i:s');
            $arr['state']=1;  //公司
            Db::name('historical')->insert($arr);       //没有就添加
        }
        Db::name('historical')->where(['id'=>$historical['id']])->update(['atime'=>date('Y-m-d H:i:s')]); //存在就修改

        $data=array('merchant'=>$merchant,'state'=>$state);

        return  json(array('code'=>1,'data'=>$data));
    }

    //语音查询
    public function yuyingSelect(){




    }


}
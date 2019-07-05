<?php
namespace app\admin\controller;
use think\Controller;
use think\Exception;
use think\Db;
class Upload extends Base
{
    public function _initialize(){
        parent::_initialize();
    }
    public function ceshi(){

        return $this->fetch();
    }
    
    //文件类操作
    public function upload(){
        $arr = glob('./upload/adminimg/*.png');//把该路径下所有的文件存到一个数组里面;
        if(request()->isAjax()){
            $page=input('p')?input('p'):1;
            $limit=12;
            $min=($page-1)*$limit;
            $max=$page*$limit;
            $res=array();
            for($i=$min;$i<$max;$i++){
                if(isset($arr[$i])){
                    $info=explode('/',$arr[$i]);
                    $res[]=array(
                        'url'=>ltrim($arr[$i],'.'),
                        'name'=>$info[3],
                    );
                }
            }
            return json($res);
        }
        $this->assign('count',count($arr));
        return $this->fetch();
    }
    //删除图片
    public function del_pic(){
        if(request()->isAjax()){
           $file='./upload/adminimg/'.input('param.file_name');
           try{
               unlink($file);
               return $this->success('删除成功!');
           }catch(Exception $e){
               return $this->error($e->getMessage());
           }
        }
    }
    //文件类操作
    public function uploads(){
        $arr = glob('/upload/adminimg/*.png');//把该路径下所有的文件存到一个数组里面;
        if(request()->isAjax()){
            $page=input('p')?input('p'):1;
            $limit=12;
            $min=($page-1)*$limit;
            $max=$page*$limit;
            $res=array();
            for($i=$min;$i<$max;$i++){
                if(isset($arr[$i])){
                    $info=explode('/',$arr[$i]);
                    $res[]=array(
                        'url'=>ltrim($arr[$i],'.'),
                        'name'=>$info[3],
                    );
                }
            }
            return json($res);
        }
        $this->assign('count',count($arr));
        return $this->fetch();
    }
}

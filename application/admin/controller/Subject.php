<?php


namespace app\admin\controller;


use think\Console;
use app\admin\model\SubjectModel;
use think\Db;
use think\Request;

class Subject extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->subject=new SubjectModel();
    }

    public function subject(){
        return $this->fetch('index');
    }
    public function lists(){
        $param=input('param.');
        $data=$this->subject->lists($param);
        return $data?['code'=>0,'msg'=>'全部分类',$data]:['code'=>1,'msg'=>'无数据',''];
    }
}
<?php
namespace app\admin\controller;


use app\admin\model\IntegralClassModel;
use think\Db;
use think\Request;

class Integralclass extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->integral=new IntegralClassModel();
    }
    /**
     * @return mixed
     * 主界面
     */
    public function integralclass(){
        return $this->fetch('index');
    }
    public function lists(){
        $param=input('param.');
        $data=$this->integral->lists($param);
        return $data['count']!=0?['code'=>0,'msg'=>'全部分类','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * @return \think\response\View
     * 添加界面
     */
    public function add_integral(Request $request){
        $param=$request->param();
        if(isset($param['id'])){
            $info=$this->integral->onedata($param['id']);
            $this->assign('info',$info);
        }
        return view();
    }
    /**
     * @param Request $request
     * @return array
     * 添加分类
     */
    public function add(Request $request){
        $param=$request->param();
        $add=$this->integral->add($param);
        return $add?['code'=>0,'msg'=>'添加成功','data'=>$add]:['code'=>1,'msg'=>'添加失败','data'=>''];

    }
    /**
     * 修改分类名称
     */
    public function edit(Request $request,$id){
        $param=$request->param();
        $param['id']=$id;
        $edit=$this->integral->edit($param);
        return $edit?['code'=>0,'msg'=>'修改成功','data'=>$edit]:['code'=>1,'msg'=>'修改失败','data'=>''];
    }
    /**
     * 删除分类
     */
    public function del($id){
        $data=$this->integral->del($id);
        return $data?['code'=>0,'msg'=>'删除成功','data'=>$data]:['code'=>1,'msg'=>'删除失败','data'=>''];

    }
}
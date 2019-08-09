<?php
namespace app\admin\controller;
use app\admin\model\PopularModel;
use think\Db;
use think\Request;

class Popular extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->popular=new PopularModel();

    }
    /**
     * @return mixed
     * 主界面
     */
    public function popular(){
        return $this->fetch('index');
    }
    public function lists(){
        $param=input('param.');
        $data=$this->popular->lists($param);
        return $data['data']?['code'=>0,'msg'=>'全部分类','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * @return \think\response\View
     * 添加词汇
     */
    public function add_popular(Request $request){
        $param=$request->param();
        if(isset($param['id'])){
            $info=$this->popular->onedata($param['id']);
            $this->assign('info',$info);
        }
        return view();
    }
    /**
     * @param Request $request
     * @return array
     * 添加词汇
     */
    public function add(Request $request){
        $param=$request->param();
        $add=$this->popular->add($param);
        return $add?['code'=>0,'msg'=>'添加成功','data'=>$add]:['code'=>1,'msg'=>'添加失败','data'=>''];

    }
    /**
     * 修改词汇名称
     */
    public function edit(Request $request,$id){
        $param=$request->param();
        $param['id']=$id;
        $edit=$this->popular->edit($param);
        return $edit?['code'=>0,'msg'=>'修改成功','data'=>$edit]:['code'=>1,'msg'=>'修改失败','data'=>''];
    }
    /**
     * 删除词汇
     */
    public function del($id){
        $data=$this->popular->del($id);
        return $data?['code'=>0,'msg'=>'删除成功','data'=>$data]:['code'=>1,'msg'=>'删除失败','data'=>''];

    }
}
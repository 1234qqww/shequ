<?php
namespace app\admin\controller;

use app\admin\model\Advise;
use app\admin\model\SubjectModel;
use app\admin\model\TopicModel;
use think\Controller;
use think\Request;

class Subject extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->subject=new SubjectModel();
        $this->topic=new TopicModel();
    }

    /**
     * @return mixed
     * 主界面
     */
    public function subject(){
        return $this->fetch('index');
    }
    public function lists(){
        $param=input('param.');
        $data=$this->subject->lists($param);
        return $data['count']!=0?['code'=>0,'msg'=>'全部分类','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * @return \think\response\View
     * 添加界面
     */

    public function add_subject(Request $request){
        $param=$request->param();
        if(isset($param['id'])){
            $info=$this->subject->onedata($param['id']);
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
        $add=$this->subject->add($param);
        return $add?['code'=>0,'msg'=>'添加成功','data'=>$add]:['code'=>1,'msg'=>'添加失败','data'=>''];
    }
    /**
     * 修改分类名称
     */
    public function edit(Request $request,$id){
        $param=$request->param();
        $param['id']=$id;
        $edit=$this->subject->edit($param);
        return $edit?['code'=>0,'msg'=>'修改成功','data'=>$edit]:['code'=>1,'msg'=>'修改失败','data'=>''];
    }
    /**
     * 删除分类
     */
    public function del($id){
        $data=$this->subject->del($id);
        return $data?['code'=>0,'msg'=>'删除成功','data'=>$data]:['code'=>1,'msg'=>'删除失败','data'=>''];

    }
    /**
     * 话题
     */
    public function topic(Request $request){
        return $this->fetch('topic');
    }
    public function topiclist(Request $request){
        $param=$request->param();
        $data=$this->topic->lists($param);
        return $data['count']!=0?['code'=>0,'msg'=>'全部话题','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 添加界面
     */
    public function add_topic(Request $request){
        return $this->fetch('add_topic');
    }
    /**
     * 上传视屏
     */
    public function update(Request $request){
        $file = $request->file('file');
        // 判断文件是否上传
        if ($file) {
            // 获取后缀名
            $ext=$file->getClientOriginalExtension();
            // 新的文件名
            $newFile=date('YmdHis',time()).'_'.rand().".".$ext;
            // 上传文件操作
            $path = public_path().'/cert/';
            if($file->move($path,$newFile)){
                return json_encode(['code'=>0,'msg'=>'文件信息','url'=>$newFile]);
            }
        }
    }
}
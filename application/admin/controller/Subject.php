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
    public function index(){
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
    public function upload_file()

    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        $test=request()->post("test");
        echo $file;
        return;
        $src=[];//返回文件路径
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                $info->getFilename();

                $src["src"]=DS.'public'.DS.'uploads'.DS.$info->getSaveName();
            }else{
                // 上传失败获取错误信息
                $file->getError();
            }
        };
        return json_encode($src);


    }
}
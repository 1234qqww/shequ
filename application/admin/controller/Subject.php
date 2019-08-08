<?php
namespace app\admin\controller;

use app\admin\model\Advise;
use app\admin\model\Goods;
use app\admin\model\SubjectModel;
use app\admin\model\Admin;
use app\admin\model\TopicModel;
use think\Request;
use think\Session;

class Subject extends Base
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->subject=new SubjectModel();
        $this->topic=new TopicModel();
        $this->goods=new Goods();
        $this->admin=new Admin();
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
        $subject=$this->subject->subjectall();
        $this->assign('subject',$subject);
        return $this->fetch('add_topic');
    }
    /**
     * 商品列表
     */
    public function shopgood(Request $request){
        $param=$request->param();
        if(isset($param['goods_id'])){
            $this->assign('goods_id',$param['goods_id']);
        }else{
            $this->assign('goods_id','');
        }
        return $this->fetch('shopgood');
    }
    public function shopgoodlist(Request $request){
        $param=$request->param();
        $data=$this->goods->goodshops($param);
        foreach($data['data'] as $k=>$val){
            if($val->id==$param['goods_id']){
                $data['data'][$k]['LAY_CHECKED']=true;
            }
        }
        return $data['count']!=0?['code'=>0,'msg'=>'全部商品','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 添加话题
     */
    public function topic_add(Request $request){
        $param=$request->param();
        $data=$this->topic->add($param);
        return $data?['code'=>0,'msg'=>'添加成功','data'=>$data]:['code'=>1,'msg'=>'添加失败','data'=>''];
    }
    /**
     * 话题修改界面
     */
    public function update_topic(Request $request){
        $param=$request->param();
        $topic=$this->topic->onedata($param['id']);
        $goods=$this->goods->onedata($topic->goods_id);
        $subject=$this->subject->subjectall();
        $this->assign('subject',$subject);
        $this->assign('topic',$topic);
        $this->assign('goods',$goods);
        return $this->fetch('update_topic');
    }
    /**
     * 修改话题内容
     */
    public function topic_edit(Request $request,$id){
        $param=$request->param();
        $param['id']=$id;
        $data=$this->topic->edit($param);
        return $data?['code'=>0,'msg'=>'修改成功','data'=>$data]:['code'=>1,'msg'=>'修改失败','data'=>''];
    }
    /**
     * 删除话题
     */
    public function topic_del($id){
        $data=$this->topic->del($id);
        return $data?['code'=>0,'msg'=>'删除成功','data'=>$data]:['code'=>1,'msg'=>'删除失败','data'=>''];
    }
    /**
     * 上传大文件
     */
    public function check(){
        // 接收相关数据
        $post = $_POST;

        // 通过MD5唯一标识找到缓存文件
        $file_path ='upload/' .$post['md5'];
        // 有断点
        if (file_exists($file_path)) {

            // 遍历成功的文件
            $block_info = scandir($file_path);

            // 除去无用文件
            foreach ($block_info as $key => $block) {
                if ($block == '.' || $block == '..') unset($block_info[$key]);
            }

            echo json_encode(['block_info' => $block_info]);
        }
        // 无断点
        else {
            echo json_encode([]);
        }
    }
    public function merge(){

        // 接收相关数据
        $post = $_POST;

        // 找出分片文件
        $dir = 'upload/' . $post['md5'];
        // 获取分片文件内容
        $block_info = scandir($dir);

        // 除去无用文件
        foreach ($block_info as $key => $block) {
            if ($block == '.' || $block == '..') unset($block_info[$key]);
        }

        // 数组按照正常规则排序
        natsort($block_info);

        // 定义保存文件
        $save_file ='upload/' . $post['fileName'];

        // 没有？建立
        if (!file_exists($save_file)) fopen($post['fileName'], "w");

        // 开始写入
        $out = @fopen($save_file, "wb");
        // 增加文件锁
        if (flock($out,LOCK_EX)) {
            foreach ($block_info as $b) {
                // 读取文件
                if (!$in = @fopen($dir . '/' . $b, "rb")) {
                    break;
                }

                // 写入文件
                while ($buff = fread($in, 4096)) {
                    fwrite($out, $buff);
                }

                @fclose($in);
                @unlink($dir . '/' . $b);
            }
            flock($out, LOCK_UN);
        }
        return ["code" =>0,"msg"=>'上传成功','url'=>$this->nowUrl().'/'.$save_file];//随便返回个值，实际中根据需要返回
    }
    public function nowUrl(){
        $host = ($this->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; //获取域名
        return $host;
    }
    public function isHTTPS()
    {
        if (defined('HTTPS') && HTTPS) return true;
        if (!isset($_SERVER)) return FALSE;
        if (!isset($_SERVER['HTTPS'])) return FALSE;
        if ($_SERVER['HTTPS'] === 1) {  //Apache
            return TRUE;
        } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
            return TRUE;
        } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
            return TRUE;
        }
        return FALSE;
    }
    /**
     * 图片上传
     */
    public function update(){
        $file = request()->file('file'); // 获取上传的文件
        if($file==null){
            exit(json_encode(array('code'=>1,'msg'=>'未上传图片')));
        }
        // 获取文件后缀
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        // 判断文件是否合法
        $info = $file->move(ROOT_PATH.'public/static/cert/'); // 移动文件到指定目录 没有则创建
        $img = $info->getSaveName();
        exit(json_encode(array('code'=>0,'msg'=>'上传成功','url'=>$this->nowUrl().'/static/cert/'.$img)));
    }
    /**
     * 图片上传
     */
    public function updates(){
        $file = request()->file('file'); // 获取上传的文件
        if($file==null){
            exit(json_encode(array('code'=>1,'msg'=>'未上传图片')));
        }
        // 获取文件后缀
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        // 判断文件是否合法
        $info = $file->move(ROOT_PATH.'public/static/cert/'); // 移动文件到指定目录 没有则创建
        $img = $info->getSaveName();
        exit(json_encode(array('code'=>0,'msg'=>'上传成功','url'=>$img)));
    }

}
<?php
namespace app\api\controller;

use app\api\model\Advise;
use app\api\model\Goods;
use app\api\model\SubjectModel;
use app\api\model\TopicModel;
use think\Config;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Subject extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->subject=new SubjectModel();
        $this->topic=new TopicModel();
        $this->goods=new Goods();
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
     * 前端分类接口
     */
    public function subjectpai(Request $request){
        $data=$this->subject->subjectall();
        return $data?json_encode(['code'=>0,'msg'=>'全部接口','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 分类下话题
     */
    public function topicpai(Request $request){
        $param=$request->param();
        $data=$this->topic->topicapi($param);
        return $data?json_encode(['code'=>0,'msg'=>'查询成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 查看详情
     */
    public function topicdet(Request $request){
        $param=$request->param();
        $data=$this->topic->onedata($param['id']);
        return $data?json_encode(['code'=>0,'msg'=>'查询成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 商品详情
     */
    public function goods_id(){
        $param=$this->request->param();
        unset($param['token']);
        $url=Config::get('host');
        $data=Db::name('goods')->where(['id'=>$param['id']])->find();
        if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$data['original_img'])){
            $data['original_img']=$this->nowUrl().$data['original_img'];
        }
        return json(['code'=>1,'msg'=>'成功','data'=>$data]);
    }


}
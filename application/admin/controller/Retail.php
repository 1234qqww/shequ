<?php
namespace app\admin\controller;

use app\common\model\Txapi;
use think\Controller;
use think\Request;
use app\admin\model\RetailModel;
use app\admin\model\BrokerModel;
use app\admin\model\UserModel;

class Retail extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->retail=new RetailModel();
        $this->broker=new BrokerModel();
        $this->user=new UserModel();
    }

    public function retail(){
        return $this->fetch('index');
    }
    /**
     * 申请列表
     */
    public function retaillists(Request $request){
        $param=$request->param();
        $data=$this->retail->retaillists($param);
        return $data['count']!=0?['code'=>0,'msg'=>'全部分类','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 通过审核
     */
    public function adopt($id){
        $apply=1;
        $data=$this->retail->adopt($id,$apply);
        return $data?['code'=>0,'msg'=>'通过审核','data'=>$data]:['code'=>1,'msg'=>'失败','data'=>$data];
    }
    /**
     * 驳回申请
     */
    public function reject($id){
        $data=$this->retail->reject($id);
        return $data?['code'=>0,'msg'=>'驳回审核','data'=>$data]:['code'=>1,'msg'=>'操作失败','data'=>$data];
    }
    /**
     * 分销商
     */
    public function reseller(){
        return $this->fetch('reseller');
    }
    /**
     * 分销商列表
     */
    public function resellerlists(Request $request){
        $param=$request->param();
        $data=$this->retail->resellerlists($param);
        return $data['count']!=0?['code'=>0,'msg'=>'全部分类','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 佣金比例
     */
    public function broker(){
        $broker=$this->broker->onedata();
        $this->assign('info',$broker);
        return $this->fetch('broker');
    }
    /**
     * 添加佣金比例
     */
    public function retadd(Request $request){
        $param=$request->param();
        if(!empty($param['id'])){
            $data=$this->broker->edit($param);
        }else{
            $data=$this->broker->add($param);
        }
        return $data?['code'=>0,'msg'=>'操作成功','data'=>$data]:['code'=>1,'msg'=>'操作失败','data'=>$data];
    }


    /**
     * @param $appid
     * @param $secret
     * @return mixed
     * 获取token
     */
    function accessToken($appid,$secret){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}&grant_type=client_credential";
        $result = $this->curlGet($url);
        $data = json_decode($result,true);
        return $data['access_token'];
    }
    /**
     * 生成小程序二维码
     */
   public function QRcode($appid,$secret,$filePath,$smallPath){
        $url = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$this->accesstoken($appid,$secret);
        $data = [
            'access_token'=>$this->accesstoken($appid,$secret),
            'path'=>$smallPath,
            'width' => "200"
        ];
        $result = $this->curlPost($url,json_encode($data));
        $filename = date('YmdHis',time())."_".rand().".png";
        file_put_contents($filePath.$filename,$result,true);
        return $filename;
    }
    /**
     * 模拟get请求
     */
    function curlGet($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        $tmpInfo = curl_exec($curl);     //返回api的json对象
        //关闭URL请求
        curl_close($curl);
        return $tmpInfo;    //返回json对象
    }

    /**
     * @param $url
     * @param $xml
     * @return bool|string
     * 模拟post请求
     */
    function curlPost($url, $xml)
    {
        $ch = curl_init();
        //设置抓取的url
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $tmpInfo = curl_exec($ch);

        //返回api的json对象
        //关闭URL请求
        curl_close($ch);
        return $tmpInfo;    //返回json对象
    }
}
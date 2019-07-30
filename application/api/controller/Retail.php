<?php
namespace app\api\controller;

use app\common\model\Txapi;
use think\Controller;
use think\Request;
use app\api\model\RetailModel;
use app\api\model\BrokerModel;
use app\api\model\UserModel;
use app\api\model\CashModel;

class Retail extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->retail=new RetailModel();
        $this->broker=new BrokerModel();
        $this->user=new UserModel();
        $this->cash=new CashModel();
    }
    /**
     * 申请成为分销商
     */
    public function applyretail(Request $request){

        $param=$request->param();
        $data=$this->retail->sel($param);
        if($data){
            return json_encode(['code'=>'0','msg'=>'已申请','data'=>$data]);
        }
        $appid=trim(Txapi::appid);
        $secret=trim(Txapi::appsecret);
        $path=ROOT_PATH.'public/static/code/';
        if (is_dir($path)){
            $filePath=$path;
        }else{
            $filePath= mkdir(iconv("UTF-8", "GBK", $path),0777,true);
        }
        $subject=new Subject();
        $subject->nowUrl();
        $param['code']= $subject->nowUrl().'/static/code/'.$this->QRcode($appid,$secret,$filePath,'pages/store/index?fid='.$param['user_id']);
        $retail=$this->retail->add($param);
        return $retail?json_encode(['code'=>'0','msg'=>'正在审核中','data'=>$data]):json_encode(['code'=>'1','msg'=>'已申请','']);
    }
    /**
     * 查看是否申请
     */
    public function ifapply(Request $request){
        $param=$request->param();
        $data=$this->retail->sel($param);
        return $data?json_encode(['code'=>'0','msg'=>'已申请','data'=>$data]):json_encode(['code'=>'1','msg'=>'未申请','']);
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
    /**
     * 店铺设置
     */
    public function setshop(Request $request){
        $param=$request->param();
        $param['headimg']=json_decode( $param['headimg']);
        $param['backimg']=json_decode( $param['backimg']);
        if(!empty($param['headimg'])){
            $param['headimg']=$param['headimg'][0];
        }
       if(!empty($param['backimg'])){
           $param['backimg']=$param['backimg'][0];
       }
       $Txapi=new Txapi();
        $parass=$this->tencentMap_address($Txapi->CONSTANT,$param['address']);
       if($parass['code']==0){
           $param['lng']=$parass['data']['lng'];
           $param['lat']=$parass['data']['lat'];
       }else{
           return json_encode(['code'=>$parass['code'],'msg'=>$parass['msg'],'data'=>'']);
       }
        $data=$this->retail->edit($param);
        return $data?json_encode(['code'=>0,'msg'=>'设置成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'设置失败','data'=>$data]);
    }
    /**
     * 查看店铺详情
     */
    public function selshop(Request $request){
        $param=$request->param();

        $data=$this->retail->selshop($param);
        return $data?json_encode(['code'=>0,'msg'=>'店铺详情','data'=>$data]):json_encode(['code'=>1,'msg'=>'查看失败','data'=>$data]);
    }
    /**
     * 我的团队
     */
    public function team(Request $request){
        $param=$request->param();
        $selshop=$this->user->oneData($param['user_id']);
        $team=$this->retail->team($param);
        $data=array(
            'selshop'=>$selshop,
            'team'=>$team
        );
        return $data?json_encode(['code'=>0,'msg'=>'我的团队','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>$data]);
    }
    function tencentMap_address($key,$address){
        $url = "https://apis.map.qq.com/ws/geocoder/v1/?address={$address}&key={$key}";
        $data =$this->curlGet($url);
        $result = json_decode($data,true);
        if(isset($result['result'])){
            return ['code'=>0,'msg'=>'获取成功','data'=>$result['result']['location']];
        }else{
            return ['code'=>1,'msg'=>'获取失败','data'=>''];
        }
    }
    /**
     * 获取所有分销商
     */
    public function distributor(Request $request){
        $param=$request->param();
        $data=$this->retail->distributor($param);
        return $data?json_encode(['code'=>0,'msg'=>'全部数据','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>'']);
    }

    /**
     * 企业转账到零钱
     */
    function transferAccounts($mch_appid,$mchid,$openid,$nonce_str,$desc,$partner_trade_no,$amount,$spbill_create_ip,$secret,$key_pem,$cert_pem){
        $data = [
            'mch_appid' =>$mch_appid,
            'mchid'=> $mchid,
            'openid' => $openid,
            'nonce_str' => $nonce_str, //随机字符串,
            'desc' => $desc,
            'check_name'=>'NO_CHECK',
            'partner_trade_no' => $partner_trade_no,
            'amount' => intval($amount * 100),
            'spbill_create_ip' => $spbill_create_ip,
        ];
        //签名
        $data['sign'] = autograph($data,$secret);
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $xml = arrayToXml($data);
        $rest = httpCurlPost($url,$xml,$key_pem,$cert_pem);
        $result = xmlToArray($rest);
        return $result;
    }

    public function cash(Request $request){
        $param=$request->param();
        $param['type']=0;
        $cash=$this->cash->add($param);
        if($cash){
            $this->retail->cash($param);
        }
        return $cash?json(['code'=>0,'msg'=>'审核中。。。','data'=>$cash]):json(['code'=>1,'msg'=>'提现失败','data'=>$cash]);
    }

}
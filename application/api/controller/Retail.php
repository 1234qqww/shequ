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
        $txpai=new Txapi();
        $appid=trim($txpai->appid);
        $secret=trim($txpai->appsecret);
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
    /**
     * 团购失败后退款
     */
    function refund($appid,$mch_id,$nonce,$ordernumber,$ordernumbers,$amount,$secret,$key_pem,$cert_pem){
        $data = [
            'appid' =>$appid,
            'mch_id'=> $mch_id,
            'nonce_str' => $nonce,
            'out_trade_no' => $ordernumber, //随机字符串,
            'out_refund_no' => $ordernumbers,
            'total_fee'=> intval($amount * 100),
            'refund_fee' =>  intval($amount * 100),
        ];
        $data['sign'] =$this-> autograph($data,$secret);
        $url ="https://api.mch.weixin.qq.com/secapi/pay/refund";
        $xml = $this->arrayToXml($data);
        $rest = $this->httpCurlPost($url,$xml,$key_pem,$cert_pem);
        $result = $this->xmlToArray($rest);
        return $result;
    }
    /**
     * @param $data
     * @return string
     * 生成签名
     */
    function autograph($data,$mer_secret)
    {
        $str = '';
        $data = array_filter($data);
        ksort($data);
        foreach ($data as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }
        $str .= 'key=' . $mer_secret;
        return strtoupper(md5($str));
    }
    /**
     * @param $arr
     * @return string
     * 数组转xml
     */
    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
    /**
     * 退款双向证书curl
     */
    function  httpCurlPost($url,$xml,$key_pem,$cert_pem){
        $ch = curl_init();
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_ENCODING, '');                     //设置header头中的编码类型
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);             //返回原生的（Raw）内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            //禁止验证ssl证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);                        //header头是否设置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH.'/public/static/cert/'. $cert_pem);
        curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH.'/public/static/cert/'. $key_pem);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $tmpInfo = curl_exec($ch);
        //返回api的json对象
        //关闭URL请求
        curl_close($ch);
        return $tmpInfo;    //返回json对象
    }
    /**
     * @param $xml
     * @return mixed
     * xml转数组
     */
    function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $val = json_decode(json_encode($xmlstring), true);

        return $val;
    }
    /**
     * 小程序支付
     */
    function initiatingPayment($amountmoney,$ordernumber,$openid,$appid,$mch_id,$mer_secret,$notify_url,$body,$attach)
    {
        $noncestr = $this->createNonceStr(); //随机字符串
        $ordercode = $ordernumber;//商户订单号
        $totamount = $amountmoney;//金额
        $attach = json_encode(['ordercode' => $ordercode]);
        $timeStamp = '' . time() . '';
        $data = [
            'openid' => $openid,
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => $noncestr, //随机字符串,
            'body' => $body,
            'attach' => $attach,
            'timeStamp' => $timeStamp,
            'out_trade_no' => $ordercode,
            'total_fee' => intval($totamount * 100),
            'spbill_create_ip' => '127.0.0.1',
            'notify_url' => $notify_url,
            'trade_type' => 'JSAPI'
        ];
        //签名
        $data['sign'] = $this->autograph($data,$mer_secret);

        $result = $this->creatPay($data);
        $rest = $this->xmlToArray($result);
        if(!isset($rest['prepay_id'])){
            return json(['code'=>2,'msg'=>'支付错误','']);
        }
        $prepay_id = $rest['prepay_id'];
        $parameters = array(
            'appId' => $appid, //小程序ID
            'timeStamp' => $timeStamp, //时间戳
            'nonceStr' => $noncestr, //随机串
            'package' => 'prepay_id=' . $prepay_id, //数据包
            'signType' => 'MD5'//签名方式
        );
        $sign = $this->autograph($parameters,$mer_secret);
        return ['prepay_id' => 'prepay_id=' . $prepay_id, 'timeStamp' => $timeStamp, 'noncestr' => $noncestr, 'sign' => $sign, 'sign_type' => 'MD5'];
    }
    function createNonceStr($length = 16)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    /**
     * 创建支付
     */
    function creatPay($data)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml =$this-> arrayToXml($data);
        $result = $this-> curlPost($url, $xml);
//      print_r(htmlspecialchars($xml));
        //$val = $this->doPageXmlToArray($result);
        return $result;
    }




}
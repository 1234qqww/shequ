<?php
namespace app\admin\controller;

use app\common\model\Txapi;
use think\Controller;
use think\Request;
use app\admin\model\RetailModel;
use app\admin\model\BrokerModel;
use app\admin\model\UserModel;
use app\admin\model\CashModel;

class Retail extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->retail=new RetailModel();
        $this->broker=new BrokerModel();
        $this->user=new UserModel();
        $this->cash=new CashModel();
        $this->subject=new Subject();
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
    /**
     * 提现申请
     */
    public function cash(){
        return $this->fetch('cash');
    }
    public function cashlists(Request $request){
        $param=$request->param();
        $param['type']=0;
        $data=$this->cash->cashlists($param);
        return $data?['code'=>0,'msg'=>'申请列表','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
    }
    /**
     * 通过申请
     */
    public function cashadopt(Request $request){
        $param=$request->param();
        $cash=$this->cash->onedata($param['id']);
        $retail=$this->retail->onedata($cash->retail_id);
        $proposed=$retail->proposed+$cash->money;
        $money=$retail->money-$cash->money;
        $this->retail->cashadopt($money,$proposed,$cash->retail_id);
//        $user=$this->user->oneData($retail->user_id);
//        $nonce_str=$this->createNonceStr();
//        $desc='分销商提现';
//        $partner_trade_no = 'Z'.date('YmdHis').rand();   //订单号
//        $spbill_create_ip='127.0.0.1';
//        $txapi=new Txapi();
//
//        $dat=$this->transferAccounts($txapi->appid,$txapi->mchid,$user->openid,$nonce_str,$desc,$partner_trade_no,0.01,$spbill_create_ip,$txapi->secret,$txapi->autograph,$txapi->templatecode);
//         $dat=$this->initiatingPayment(0.01,12346,$user->openid,$txapi->appid,$txapi->mchid,$txapi->secret,url('admin/retail/cashreject'),0.01,'支付','');

        $param['type']=1;
        $data=$this->cash->adopt($param);
        return $data?['code'=>0,'msg'=>'申请通过','data'=>$data]:['code'=>1,'msg'=>'失败','data'=>$data];
    }
    /**
     * 驳回申请
     */
    public function cashreject(Request $request){
        $param=$request->param();
        $cash=$this->cash->onedata($param['id']);
        $retail=$this->retail->onedata($cash->retail_id);
        $money=$cash->money+$retail->money;
        $this->retail->moneys($money,$retail->id);
        $data=$this->cash->reject($param);
        return $data?['code'=>0,'msg'=>'申请被驳回','data'=>$data]:['code'=>1,'msg'=>'失败','data'=>$data];
    }
    /**
     * 提现记录
     */
    public function cashrecord(){
        return $this->fetch();
    }
    public function recordlists(Request $request){
        $param=$request->param();
        $param['type']=1;
        $data=$this->cash->cashlists($param);
        return $data?['code'=>0,'msg'=>'提现记录','data'=>$data['data'],'count'=>$data['count']]:['code'=>1,'msg'=>'无数据','data'=>$data['data'],'count'=>$data['count']];
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
        $data['sign'] = $this->autograph($data,$secret);

        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        $xml = $this->arrayToXml($data);
        $rest = $this->httpCurlPost($url,$xml,$key_pem,$cert_pem);
        $result = $this->xmlToArray($rest);
        return $result;
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

    /**
     * 日志
     */
    public function mylog($msg,$file_dir='',$is_default_dir = true) {
        if($is_default_dir){
            $common_dir_path = '..'.DS.'runtime/log'.DS.'log';
            if(empty($file_dir)){
                $file_dir = $common_dir_path.DS.date('Ym').DS.date('Y-m-d').'.log';
            }else{
                $file_dir = $common_dir_path.$file_dir;
            }
        }
        $dir = dirname($file_dir);
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $now_time = date('Y-m-d H:i:s',time());
        file_put_contents($file_dir,'['.$now_time.']'."\n".'log_msg:'.$msg."\n",FILE_APPEND);
    }

}
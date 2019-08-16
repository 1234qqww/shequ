<?php


namespace app\api\controller;
use app\common\model\Txapi;
use think\Config;
use think\Db;
include_once "wxBizDataCrypt.php";

class Login extends   Base
{
    //登录储存数据库
    public function login(){
        $param=$this->request->param();
        if(!$param['code']){
            echo json_encode(array('code'=>0,'msg'=>'非法操作！'));
            exit();
        }
        $code=trim($param['code']);
        $txapi=new Txapi();
        $appid=trim($txapi->appid);
        $appsecret=trim($txapi->appsecret);
        $get_token_url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$code.'&grant_type=authorization_code';
        //        $get_token_url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx6071a4f5cfa26455&secret=342394868bb290de0e167c02db13895b&js_code=081TssVq0x9ZRm1rOuWq0yjBVq0TssVZ&grant_type=authorization_code'
        $weixin=file_get_contents($get_token_url);
        $jsondecode=json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $openid = $array['openid'];//输出openid
        $user=Db::name('user')->where(['openid'=>$openid])->find();
        if(!$user){
            $arr['openid']=$openid;
            $arr['userName']=$param['nickname'];
            $arr['userImg']=$param['headimgurl'];
            $arr['fid']=$param['fid'];
            $arr['atime']=date('Y-m-d H:i:s');
            $arr['userid']=date('Ydis',time());
            $data=Db::name('user')->insertGetId($arr);
            if($data){
                return json(array('code'=>1,'msg'=>'操作成功','data'=>$data));
            }
        }
        return json(array('code'=>1,'msg'=>'登录成功','data'=>$user['id']));
    }

}
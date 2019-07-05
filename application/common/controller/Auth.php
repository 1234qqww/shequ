<?php
/**
 * Created by IntelliJ IDEA.
 * User: yvdedu.com
 * Date: 2018/12/27
 * Time: 11:11
 */

namespace app\common\controller;

use app\common\util\Strs;

class Auth extends Base
{
    protected $loginType;  //存储登陆信息类型  session  cache
    protected $currentUser=null;

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 检测是否登录
     */
    protected function checkLoginGlobal($accessToken=null)
    {
        $check_success = false;
        switch ($this->loginType) {
            case "session";
                $nowUser = session('nowUser');
                if ($nowUser) {
                    $this->currentUser = $nowUser;
                    $check_success = true;
                }
                break;
            default:
                if($accessToken){
                    $nowUser = cache("token_".$accessToken);
                    if ($nowUser) {
                        $this->currentUser = $nowUser;
                        $check_success = true;
                        //刷新 缓存有效期
                        $expires = config('token_timeout');
                        cache('token_' . $accessToken, $nowUser, $expires);
                    }
                }
                break;
        }
        return $check_success;
    }
    /**
     * 设置全局登录
     * #Date:
     */
    protected function setLoginGlobal($currentUser = [])
    {
        $set_success = false ;
        if ($currentUser) {
            switch ($this->loginType) {
                case "session":
                    session('nowUser', $currentUser);
                    $set_success = true;
                    break;
                default :
                    $accessToken = $this->buildAccessToken($currentUser['id'],$currentUser['name']);
                    $expires = config('token_timeout');
                    cache('token_' . $accessToken, $currentUser, $expires);
                    $set_success = true;
                    break;
            }
        }
        if (!$set_success) return false;
        return $this->loginType=='session'?true:$accessToken;
    }
    /**
     * 计算出唯一的身份令牌
     * @param $name
     * @param $pwd
     * @return string
     */
    private function buildAccessToken($id, $name)
    {
        $preStr = $id . $name . time() . Strs::keyGen();
        return md5($preStr);
    }
}
<?php


namespace app\common\model;


use think\Config;
use think\Model;

//坐标拾取
class Txapi extends Model
{
    public function __construct(){
       $qudao=Config::get("qudao");
        $this->appid=$qudao['appid'];
        $this->appsecret=$qudao['appsecret'];
        $this->mchid=$qudao['mchid'];
        $this->secret=$qudao['secret'];
        $this->autograph=$qudao['autograph'];
        $this->templatecode=$qudao['templatecode'];
        $this->CONSTANT='ZS4BZ-V743I-2XGGL-52DY5-VDY2V-FJFRI';
    }

//    const CONSTANT = 'ZS4BZ-V743I-2XGGL-52DY5-VDY2V-FJFRI';
////    const appid='wx1d2f233b4c28773b';
////    const appsecret='5eab82a4cb0f0ebd4e8cd7b39c2b7333';

    public function coordinate( $address){
        $url = "http://apis.map.qq.com/ws/geocoder/v1/?address=$address&key=". $this->CONSTANT;
// 初始url会话
        $ch = curl_init();
//  设置url传输选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 执行url会话
        $data = curl_exec($ch);
        $map = json_decode($data);
        $location = $map->result->location;
       return $location;
//        echo "经度:".$location->lng."<br/>";// 经度
//
//        echo "纬度:".$location->lat."<br/>";// 纬度
    }


    public function decryptData( $encryptedData, $iv, &$data )
    {

        if (strlen( $this->appsecret) != 24) {
            return -41001;
        }
        $aesKey=base64_decode( $this->appsecret);


        if (strlen($iv) != 24) {
            return -41002;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return -41003;
        }
        if( $dataObj->watermark->appid != $this->appid)
        {
            return -41003;
        }
        $data = $result;
        return 0;
    }




    //x的值代表的是经度，y值代表的是维度
    public  function getJuli($aY, $aX, $bY, $bX)
    {
        $earthRadius = 6367000;
        $aY = ($aY * pi()) / 180;
        $aX = ($aX * pi()) / 180;
        $bY = ($bY * pi()) / 180;
        $bX = ($bX * pi()) / 180;
        $distanceX = $bX - $aX;
        $distanceY = $bY - $aY;
        $stepOne = pow(sin($distanceY / 2), 2) + cos($aY) * cos($bX) * pow
            (sin($distanceX / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;
        return round($calculatedDistance) / 1000;
    }






}



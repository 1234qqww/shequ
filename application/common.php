<?php
use think\captcha\Captcha;
use think\config;
use think\Db;
function public_functions(){
    return [
        'home'=>[
            'welcome'
        ],
        'admin-index'=>[
            'index-data'
        ],
        'admin-role'=>[
            'role_data'
        ],
        'admin-index'=>[
            'index_data'
        ],
        'admin-del_admin'=>[
            'del_admin_pl'
        ],
        'home-menu'=>[
            'menu_data'
        ],
    ];
}
// 应用公共文件
/*
 * 加密
 */
function hhtc_encrypt($str){
    return md5(md5("honghaotiancheng".$str));
}
function downloadExcel($strTable,$filename)
{
    header("Content-type: application/vnd.ms-excel");
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".xls");
    header('Expires:0');
    header('Pragma:public');
    echo '<html><meta http-equiv="Content-Type" article="text/html; charset=utf-8" />'.$strTable.'</html>';
}

function downloadWord($strTable,$filename)
{
    header("Content-type: application/vnd.ms-word");
    header("Content-Type: application/force-download");
    header("Content-Disposition: attachment; filename=".$filename."_".date('Y-m-d').".doc");
    header('Expires:0');
    header('Pragma:public');
    echo '<html><meta http-equiv="Content-Type" article="text/html; charset=utf-8" />'.$strTable.'</html>';
}

//图片验证码
function getcaptcha($id=1,$code=''){
    if($code==''){
        $config =    [
            // 验证码字体大小
            'fontSize'    =>    180,
            // 验证码位数
            'length'      =>    4,
            // 关闭验证码杂点
            'useNoise'    =>    false,
        ];
        $captcha = new Captcha($config);
        return $captcha->entry($id);
    }
    $captcha = new Captcha();
    return $captcha->check($code, $id);
}

//后台操作日志
function admin_log($describe,$admin_id=''){
    $data['ip']=$_SERVER['REMOTE_ADDR'];
    if($data['ip']!='127.0.0.1'){
        $url="http://api.map.baidu.com/location/ip?ak=gMbGAcMvKWGSNaHVfwgN1lC2quFVijMF&ip=".$data['ip'];
        $res=@file_get_contents($url);
        $arr=json_decode($res,true);
        if(isset($arr['article']['address'])){
            $data['address']=$arr['article']['address'];
        }
    }

    $data['time']=date('Y-m-d H:i:s');
    $data['admin_id']=($admin_id=='')?session('admin_id'):$admin_id;
    $data['describe']=$describe;
    Db::name('admin_log')->insert($data);
}
//base64转图片
function base64toimg($code){
    $file_name="hhtc_".date("Ymdhis",time())."_".rand(111,999).'.png';
    $imageSrc="./upload/adminimg/". $file_name;
    if (strstr($code,",")){
        $code = explode(',',$code);
        $code = $code[1];
    }
    file_put_contents($imageSrc, base64_decode($code));
    return '/upload/adminimg/'.$file_name;
}

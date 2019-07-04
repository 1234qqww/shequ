<?php

namespace app\common\model;
use think\Model;
class Common extends Model {
    public function success($msg){
        $res['code']='1';
        $res['msg']=$msg;
        return $res;
    }
    public function error($msg){
        $res['code']='0';
        $res['msg']=$msg;
        return $res;
    }
}
?>
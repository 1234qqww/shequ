<?php

namespace app\common\controller;

use app\common\util\ReturnCode;
use think\Controller;
use think\Loader;

class Base extends Controller
{
    protected static function showReturnCode($code = '', $data = [], $msg = '')
    {
        $return_data = [
            'code' => '500',
            'msg' => '未定义消息',
            'data' => $code == 1001 ? $data : [],
        ];
        if (empty($code)){
            //如果参数$code为空，返回错误消息
            return $return_data;
        }
        //如果参数$code为不为空，替换内置code
        $return_data['code'] = $code;
        if(!empty($msg)){
            //如果$msg不为空，替换内置$msg
            $return_data['msg'] = $msg;
        }else if (isset(ReturnCode::$return_code[$code]) ) {
            //判断错误消息$code是否设置
            //替换掉，替换内置$msg
            $return_data['msg'] = ReturnCode::$return_code[$code];
        }
        return $return_data;
    }

    protected static function showReturnCodeWithOutData($code = '', $msg = '')
    {
        //重写showReturnCode方法
        return self::showReturnCode($code,[],$msg);
    }

    /**
     * 数据库字段 网页字段转换
     * @param $array 转化数组
     * @return 返回数据数组
     */
    protected function buildParam($array=[])
    {
        $data=[];
        if (is_array($array)&&!empty($array)){
            foreach( $array as $item=>$value ){
                $data[$item] = $this->request->param($value);
            }
        }
        return $data;
    }

    /**
     * 快速修改
     * @param $array
     * @param bool|false $validate_name
     * @param string $model_name
     * @return array 返回code码
     */
    protected function editData($parameter = false, $validate_name = false, $model_name = false, $save_data = [])
    {
        //$parameter：请求数据   $validate_name ：验证的方式   $model_name 模型名
        if (empty($save_data)) {
            if ($parameter != false && is_array($parameter)) {
                $data = $this->buildParam($parameter);
            } else {
                $data = $this->request->post();
            }
        } else {
            $data = $save_data;
        }
        if (!$data) return $this->showReturnCode(1003,'参数不能为空！');
        return $this->doModelAction($data,$validate_name,$model_name);
    }
    protected function doModelAction($param_data,$validate_name = false, $model_name = false,$action_name='editData',$id=null,$true=true){
        if ($validate_name != false) {
            $result = $this->validate($param_data, $validate_name);
            if (true !== $result) return $this->showReturnCodeWithOutData(1003,  $result);
        }
        $model = Loader::model($model_name);  //实例化数据模型
        if (!$model) return $this->showReturnCode(1010,"数据模型不存在");
        return $model->$action_name($param_data,$true,$id);
    }

}
<?php
namespace app\admin\controller;

use app\common\controller\Auth;
use think\Request;
use think\Db;
class GS extends Auth
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index(Request $request){
       $param= $request->param();
        echo "<pre>";
        print_r($param);
        echo "</pre>";
        if (isset($param['merchantid'])) {
            echo 1;
            session('merchantid', $param['merchantid']);
        } else {
            echo 2;
            session('merchantid', -1);
        }
    }
}

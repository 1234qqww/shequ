<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
include __DIR__ . '../../../vendor/workerman/Autoloader.php';

// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

// 启动4个进程对外提供服务
$http_worker->count = 4;
class Report extends Base
{

    public function _initialize(){
        parent::_initialize();
    }
    public function report()
    {
        return $this->fetch('index');
    }


}

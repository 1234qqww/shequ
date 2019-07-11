<?php
namespace app\api\controller;

use think\worker\Server;
use Workerman\Worker;

class Timely extends Server
{
    protected $socket = 'websocket://sq.zxrhyc.cn:2346';
    public function __construct()
    {
        $context = array(
            // 更多ssl选项请参考手册 http://php.net/manual/zh/context.ssl.php
            'ssl' => array(
                // 请使用绝对路径
                'local_cert'                 => '/www/wwwroot/sq.zxrhyc.cn/public/certificate/2471359_sq.zxrhyc.cn.pem', // 也可以是crt文件
                'local_pk'                   => '/www/wwwroot/sq.zxrhyc.cn/public/certificate/2471359_sq.zxrhyc.cn.key',
                'verify_peer'                => false,
                // 'allow_self_signed' => true, //如果是自签名证书需要开启此选项
            )
        );
        $worker = new Worker('websocket://0.0.0.0:2346', $context);
        $worker->count =4;
        $worker->transport = 'ssl';
        Worker::runAll();
    }


    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        $connection->send('sadfasd');
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
      echo 'success';
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {

    }
    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code $msg\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
    }


}
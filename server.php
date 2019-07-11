<?php
require_once __DIR__ . '/vendor/workerman/workerman/Autoloader.php';
use Workerman\Worker;
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

$worker->count =1;
// 设置transport开启ssl，websocket+ssl即wss
$worker->transport = 'ssl';
$worker->uidConnections = array();

$worker->onMessage = function($connection, $data){

    global $worker;
    foreach($worker->connections as $conn)
    {
        $conn->send($data);
    }
//    $ss= explode(':', $data);
//    global $worker;
//      if(!isset($connection->uid)){
//          $connection->uid = $ss[0];
//          $worker->uidConnections[$connection->uid] = $connection;
//         return $connection->send('login success, your uid is ' . $connection->uid);
//
//
//      }
//    if($ss[0] == 'all')
//    {
//        echo 2;
//        broadcast($ss[1]);
//    }
//    // 给特定uid发送
//    else
//    {
//        sendMessageByUid($ss[0], $ss[1]);
//    }




};
function broadcast($message)
{
    global $worker;
    foreach($worker->uidConnections as $connection)
    {
        $connection->send($message);
    }
}

// 针对uid推送数据
function sendMessageByUid($uid, $message)
{
    global $worker;
    if(isset($worker->uidConnections[$uid]))
    {
        $connection = $worker->uidConnections[$uid];
        $connection->send($message);
    }
}
/**
 * 当连接建立时触发的回调函数
 * @param $connection
 */
$worker->onConnect=function($connection){
    echo 'success';
};
/**
 * 当连接断开时触发的回调函数
 * @param $connection
 */
$worker->onClose=function($connection){
    echo 'error';
};
/**
 * 当客户端的连接上发生错误时触发
 * @param $connection
 * @param $code
 * @param $msg
 */
$worker->onError=function($connection){
    echo 'onError';
};
/**
 * 每个进程启动
 * @param $worker
 */
$worker->onWorkerStart=function($connection){
    echo 'onError';
};
Worker::runAll();


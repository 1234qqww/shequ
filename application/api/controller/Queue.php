<?php
namespace app\api\controller;
use app\api\model\GroupregimentModel;
//use app\api\model\Order;
use app\common\model\Txapi;
use think\Controller;

class Queue extends Controller

{
    //队头指针
    private $_front;
    //队尾指针
    private $_rear;
    //队列数组
    private $_queue;
    //队列实际长度
    private $_queueLength;
    //队列容量
    private $_queueSize;
    /**
     * Queue constructor.初始化队列
     * @param int $capacity 容量（循环队列的最大长度）
     */
    public function __construct($size){
        $this->_queue = [];
        $this->_queueSize = $size;
        $this->_front = 0;
        $this->_rear = 0;
        $this->_queueLength = 0;
    }
    /**
     * 销毁队列；
     */
    public function __destruct(){
        unset($this->_queue);
    }
    /**
     * @method 入队
     * @param mixed $elem 入队的元素
     * @return bool
     */
    public function enQueue($elem){
        if (!$this->isFull()) {
            $this->_queue[$this->_rear] = $elem;
            $this->_rear++;
            $this->_rear = $this->_rear % $this->_queueSize;
            $this->_queueLength++;
            return true;
        }
        return false;
    }
    /**
     * @method 出队
     * @return mixed|null
     */
    public function deQueue(){
        if (!$this->isEmpty()) {

            $value = $this->_queue[$this->_front];
                        $txapi=new Txapi();
            $ss=new Group();
            $nonce= $ss->createNonceStr();
            $str="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
            $strs=substr(str_shuffle($str),mt_rand(0,strlen($str)-11),1);
            $ordernumbers='H'.date('ymdHis') .$strs;
            //退款
            $retail=new Retail();
            @$refund= $retail->refund($txapi->appid,$txapi->mchid,$nonce,$value->order_sn,$ordernumbers,$value->total_amount,$txapi->secret,$txapi->autograph,$txapi->templatecode);
            $ss=new \app\admin\controller\Retail();
//            $ss->mylog(json_encode($refund,JSON_UNESCAPED_UNICODE),'','log.txt');
            if($refund['return_code']=='success' && $refund['result_code']=='success'){
               $data=array(
                   'order_sn'=>$value->order_sn,
                   'user_id'=>$value->user_id,
                    'money'=>$value->total_amount
               );
               $groupregiment=new GroupregimentModel();
               @$groupregiment->add($data);
               $order=new Order();
               @$order->dissolution($value->id);
           };
            //团购失败后添加退款记录

            $this->_front++;
            $this->_front %= $this->_queueSize;
            $this->_queueLength--;

            return $value;
        }
        return null;
    }
    /**
     * @method 判断队列是否为空；
     * @return bool
     */
    public function isEmpty(){
        return $this->_queueLength === 0;
    }
    /**
     * @method 判断队列是否饱和；
     * @return bool
     */
    public function isFull(){
        return $this->_queueLength === $this->_queueSize;
    }
    /**
     * @method 遍历队列并输出（测试队列）
     */
    public function outputQueue(){
        for ($i = $this->_front; $i < $this->_queueLength + $this->_front; $i++) {
            echo $this->_queue[$i % $this->_queueSize].PHP_EOL;
        }
    }
    /**
     * @method 清空队列
     */
    public function clearQueue()
    {
        $this->_queue = [];
        $this->_front = 0;
        $this->_rear = 0;
        $this->_queueLength = 0;
    }

}
<?php


namespace app\api\model;


use think\Config;
use think\Db;
use think\Model;
use think\Paginator;

class GroupregimentModel extends Model
{
    protected $table='hhtc_groupregiment';  //表名称
    /**
     * 添加团购订单退款记录
     */
    public function add($param){
        $data['order_sn']=isset($param['order_sn'])?$param['order_sn']:'';
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['money']=isset($param['money'])?$param['money']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }

}
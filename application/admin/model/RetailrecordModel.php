<?php

namespace app\admin\model;
use think\Model;
class RetailrecordModel extends Model {
    protected $table='hhtc_retailrecord';  //表名称

    public function onedata(){
        return $this->find();
    }
    /**
     * 添加记录
     */
    public function add($param){
        $data['good_id']=isset($param['good_id'])?$param['good_id']:'';
        $data['moneys']=isset($param['moneys'])?$param['moneys']:'';
        $data['order_id']=isset($param['order_id'])?$param['order_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 商户给分销商转账记录
     */
    public function carrylist($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $key = $param['key'];
            $query = $query->hasWhere(
                'order',function($query) use ($key){
                $query->where('order_sn','like',"%{$key}%");
            }
            );
        }
        $data=$query->page($page)->with('order')->with('good')->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 关联订单表
     */
    public function order(){
        return $this->hasOne('Order','id','order_id');
    }
    /**
     * 关联商户表
     */
    public function good(){
        return $this->hasOne('Good','id','good_id');
    }

}
?>
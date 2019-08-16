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
        $data['moneys']=isset($param['moneys'])?$param['moneys']:'';
        $data['order_id']=isset($param['order_id'])?$param['order_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }

}
?>
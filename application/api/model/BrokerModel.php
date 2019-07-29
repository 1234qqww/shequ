<?php

namespace app\api\model;
use think\Model;
class BrokerModel extends Model {
    protected $table='hhtc_broker';  //表名称

    public function onedata(){
        return $this->find();
    }
    /**
     * 添加佣金比例
     */
    public function add($param){
        $data['broker']=isset($param['broker'])?$param['broker']:'';
        $data['percent']=isset($param['percent'])?$param['percent']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 修改佣金比例
     */
    public function edit($param){
        if(!empty($param['broker'])){
            $data['broker'] = $param['broker'];
        }
        if(!empty($param['percent'])){
            $data['percent'] = $param['percent'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
        return $this->where('id',$param['id'])->update($data);
    }
}
?>
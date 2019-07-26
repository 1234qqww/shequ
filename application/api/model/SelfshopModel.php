<?php

namespace app\api\model;
use think\Model;
class SelfshopModel extends Model {
    protected $table='hhtc_selfshop';  //表名称
    /**
     * 添加自选商品
     */
    public function add($param){
        $data['ids']=isset($param['ids'])?$param['ids']:'';
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['retail_id']=isset($param['retail_id'])?$param['retail_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 查看是否添加
     */
    public function ifs($param){
        return $this->where('retail_id',$param['retail_id'])->find();
    }
    /**
     * 修改自选商品
     */
    public function edit($param){
        return $this->where('retail_id',$param['retail_id'])->update(['ids'=>$param['ids'],'updated_at'=>date('Y-m-d H:i:s')]);
    }
//    /**
//     * 修改佣金比例
//     */
//    public function edit($param){
//        if(!empty($param['broker'])){
//            $data['broker'] = $param['broker'];
//        }
//        if(!empty($param['percent'])){
//            $data['percent'] = $param['percent'];
//        }
//        $data['updated_at']=date('Y-m-d H:i:s');;
//        return $this->where('id',$param['id'])->update($data);
//    }
}
?>
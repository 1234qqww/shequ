<?php

namespace app\api\model;
use think\Model;
class EtcModel extends Model {
    protected $table='hhtc_etc';  //表名称
    /**
     * 添加记录
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['etc']=isset($param['etc'])?$param['etc']:'';
        $data['money']=isset($param['money'])?$param['money']:'';
        $data['amount']=isset($param['amount'])?$param['amount']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d  H:i:s');
        return $this->save($data);
    }
    /**
     * 查询余额记录
     */
    public function useetc($user_id){
        return $this->where('user_id',$user_id)->select();
    }
}
?>
<?php

namespace app\api\model;
use think\Model;
class TrandcommentModel extends Model {
    protected $table='hhtc_trandcomment';  //表名称
    /**
     * 查看关于某条动态的评论
     */
    public function comment($trand_id){
        return $this->with('user')->where('trand_id',$trand_id)->where('cid',0)->select();

    }
    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('user','id','user_id');
    }
    /**
     * 回复他人的评论
     */
    public function cidcomment($trand_id,$cid){
        return $this->with('user')->where('trand_id',$trand_id)->where('cid',$cid)->select();
    }
    /**
     * 评论详情
     */
    public function oneData($id){
        return $this->with('user')->where('id',$id)->find();
    }
    /**
     * 添加
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['trand_id']=isset($param['trand_id'])?$param['trand_id']:'';
        $data['content']=isset($param['content'])?$param['content']:'';
        $data['cid']=isset($param['cid'])?$param['cid']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * @param $param
     * @return false|int
     * 删除
     */
    public function del($param){
        return $this->where('user_id',$param['user_id'])->where('trand_id',$param['trand_id'])->delete();
    }
}
?>
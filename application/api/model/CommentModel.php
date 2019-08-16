<?php

namespace app\api\model;
use think\Model;
class CommentModel extends Model {
    protected $table='hhtc_comment';  //表名称
    /**
     * 添加商品评论
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['goods_id']=isset($param['goods_id'])?$param['goods_id']:'';
        $data['content']=isset($param['content'])?$param['content']:'';
        $data['image']=isset($param['image'])?$param['image']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d  H:i:s');
        return $this->save($data);
    }
    /**
     * 查看某商品的评论
     */
    public function goodComment($goods_id){
        return $this->where('goods_id',$goods_id)->with('user')->select();
    }
    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('UserModel','id','user_id');
    }

}
?>
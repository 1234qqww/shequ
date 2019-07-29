<?php

namespace app\admin\model;
use think\Model;
use think\Db;
class ReportModel extends Model {
    protected $table='hhtc_report';  //表名称

    /**
     * 分类全部数据
     */
    public function storelists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('title','like',"%{$param['key']}%");
        }
        $data=$query->with('user')->where('reseller',$param['reseller'])->page($page)->limit($limit)->order('id','Desc')->group('user_id')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 查看聊天记录
     */
    public function see($param){
        return $this->where('user_id',$param['user_id'])->where('store_id',$param['store_id'])->with('user')->with('goods')->order('id','Desc')->limit(20)->select();
    }
    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('UserModel','id','user_id');
    }
    /**
     * 关联店铺表
     */
    public function goods(){
        return $this->hasOne('Good','id','store_id');
    }
    /**
     * 添加店铺问题
     */
    public function add($param){
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['store_id']=isset($param['store_id'])?$param['store_id']:'';
        $data['text']=isset($param['text'])?$param['text']:'';
        $data['read']=isset($param['read'])?$param['read']:'';
        $data['flag']=isset($param['flag'])?$param['flag']:'';
        $data['disnate']=isset($param['disnate'])?$param['disnate']:'';
        $data['reseller']=isset($param['reseller'])?$param['reseller']:'';
        $data['retail_id']=isset($param['retail_id'])?$param['retail_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 分类详情
     */
    public function onedata($id){
        return $this->get($id);
    }
    /**
     * 修改分类
     */
    public function edit($param){
        if(!empty($param['title'])){
            $data['title'] = $param['title'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->where('id',$param['id'])->update($data);
    }
    /**
     * 删除分类
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 分类的全部数据
     */
    public function subjectall(){
        return $this->order('id','Desc')->select();
    }
    /**
     * 查看未读消息
     */
    public function readstore($param){
        return $this->where('user_id',$param['user_id'])->where('store_id',$param['store_id'])->where('disnate','neq',$param['disnate'])->select();
    }
    /**
     * 改为已读
     */
    public function already($id){
        $this->where('id',$id)->update(['read'=>1]);
    }

}
?>
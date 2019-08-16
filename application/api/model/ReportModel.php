<?php

namespace app\api\model;
use think\Model;
use think\Db;
class ReportModel extends Model {
    protected $table='hhtc_report';  //表名称
    /**
     * 查看用户关于分销商的全部消息
     */
    public function allnews($param,$reseller){
        $data=$this->with('user')->with('retail')->with('goods')->where('user_id',$param['user_id'])->group('retail_id')->order(['id'=>'asc'])->select();

        foreach($data as $k=>$val){
            $data[$k]['count']=$this->where('read',0)->with('user')->with('retail')->with('goods')->where('disnate',1)->where('read',0)->where('retail_id',$val->retail_id)->where('user_id',$param['user_id'])->count();
        }
        return $data;
    }
    /**
     * 查看用户关于店铺的全部消息
     */
    public function allstore($param,$reseller){
        $data=$this->with('user')->with('retail')->with('goods')->where('reseller',$reseller)->where('user_id',$param['user_id'])->group('store_id')->order(['id'=>'asc'])->select();
        foreach($data as $k=>$val){
            $data[$k]['count']=$this->where('read',0)->with('user')->with('retail')->with('goods')->where('disnate',1)->where('read',0)->where('store_id',$val->store_id)->where('user_id',$param['user_id'])->count();
        }
        return $data;
    }
    /**
     * 分销商关于用户的全部数据
     */
    public function storelists($param,$reseller){
        $data= $this->with('user')->with('retail')->with('goods')->where('user_id',$param['user_id'])->where('retail_id',$param['retail_id'])->where('reseller',$reseller)->group('user_id')->order(['id'=>'asc'])->select();
        foreach($data as $k=>$val){
            $data[$k]['count']=$this->where('read',0)->with('user')->with('retail')->with('goods')->where('disnate',0)->where('reseller',$reseller)->where('retail_id',$val->retail_id)->where('user_id',$param['user_id'])->count();
        }
        return $data;
    }
    /**
     *查看最后一条数据 分销商
     */
    public function last($user_id,$retail_id,$reseller){
        return $this->with('user')->with('retail')->with('goods')->where('user_id',$user_id)->where('retail_id',$retail_id)->where('reseller',$reseller)->order('id','Desc')->find();
    }
    /**
     *查看最后一条数据 店铺
     */
    public function storelast($user_id,$store_id,$reseller){
        return $this->with('user')->with('retail')->with('goods')->where('user_id',$user_id)->where('store_id',$store_id)->where('reseller',$reseller)->order('id','Desc')->find();
    }
    /**
     * 查看聊天记录
     */
    public function see($param){
        return $this->where('user_id',$param['user_id'])->where('store_id',$param['store_id'])->with('user')->with('goods')->order('id','Desc')->limit(20)->select();
    }
    /**
     * 查看聊天记录
     */
    public function retailsee($param){
        if(isset($param['store_id'])){

            return $this->where('user_id',$param['user_id'])->with('retail')->where('store_id',$param['store_id'])->with('user')->with('goods')->order('id','Desc')->limit(20)->select();

        }else{
            return $this->where('user_id',$param['user_id'])->with('retail')->where('retail_id',$param['retail_id'])->with('user')->with('goods')->order('id','Desc')->limit(20)->select();
        }
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
     * 关联分销商
     */
    public function retail(){
        return $this->hasOne('RetailModel','id','retail_id');
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
     * 查看未读消息
     */
    public function readretail($param){
        return $this->where('user_id',$param['user_id'])->where('retail_id',$param['retail_id'])->where('disnate','neq',$param['disnate'])->select();
    }
    /**
     * 改为已读
     */
    public function already($id){
        $this->where('id',$id)->update(['read'=>1]);
    }

}
?>
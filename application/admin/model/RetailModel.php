<?php

namespace app\admin\model;
use think\Model;
class RetailModel extends Model {
    protected $table='hhtc_retail';  //表名称

    /**
     * 申请列表
     */
    public function retaillists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $key = $param['key'];
            $query = $query->hasWhere(
                'user',function($query) use ($key){
                    $query->where('userName','like',"%{$key}%");
            }
            );
        }
        $data=$query->with('user')->with('fuser')->where('apply',0)->page($page)->limit($limit)->order('id','Desc')->group('user_id')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 分销商列表
     */
    public function resellerlists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $key = $param['key'];
            $query = $query->hasWhere(
                'user',function($query) use ($key){
                $query->where('userName','like',"%{$key}%");
            }
            );
        }
        $data=$query->with('user')->with('fuser')->where('apply',1)->page($page)->limit($limit)->order('id','Desc')->group('user_id')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 通过审核
     */
    public function adopt($id,$apply){
        return $this->where('id',$id)->update(['apply'=>$apply]);
    }
    /**
     * 驳回申请
     */
    public function reject($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 关联用户表
     */
    public function user(){
        return $this->hasOne('app\admin\model\UserModel','id','user_id');
    }
    /**
     * 推荐人
     */
    public function fuser(){
        return $this->hasOne('UserModel','id','fid');
    }

    /**
     * 查看是否是分销商
     */
    public function sel($param){
        return $this->with('user')->with('fuser')->where('user_id',$param['user_id'])->find();
    }
    /**
     * 申请成为分销商
     */
    public function add($param){
        $data['money']=isset($param['money'])?$param['money']:'';
        $data['shopname']=isset($param['shopname'])?$param['shopname']:'';
        $data['headimg']=isset($param['headimg'])?$param['headimg']:'';
        $data['backimg']=isset($param['backimg'])?$param['backimg']:'';
        $data['phone']=isset($param['phone'])?$param['phone']:'';
        $data['user_id']=isset($param['user_id'])?$param['user_id']:'';
        $data['address']=isset($param['address'])?$param['address']:'';
        $data['fid']=isset($param['fid'])?$param['fid']:'';
        $data['code']=isset($param['code'])?$param['code']:'';
        $data['apply']=isset($param['apply'])?$param['apply']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 补存店铺信息
     */
    public function edit($param){
        if(!empty($param['shopname'])){
            $data['shopname'] = $param['shopname'];
        }
        if(!empty($param['backimg'])){
            $data['backimg'] = $param['backimg'];
        }
        if(!empty($param['headimg'])){
            $data['headimg'] = $param['headimg'];
        }
        if(!empty($param['phone'])){
            $data['phone'] = $param['phone'];
        }
        if(!empty($param['address'])){
            $data['address'] = $param['address'];
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->where('user_id',$param['user_id'])->update($data);
    }
    /**
     * 根据user_id查看店铺信息
     */
    public function selshop($param){
        return $this->where('user_id',$param['user_id'])->find();
    }
    /**
     * 我的团队
     */
    public function team($param){
        return $this->with('user')->where('fid',$param['user_id'])->select();
    }
    /**
     * 分销商详情
     */
    public function oneData($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 提现申请驳回后退回金额
     */
    public function moneys($money,$id){
        return $this->where('id',$id)->update(['money'=>$money]);
    }
    /**
     * 提现申请成功后增加
     */
    public function cashadopt($money,$proposed,$id){
        return $this->where('id',$id)->update(['money'=>$money,'proposed'=>$proposed]);

    }

}
?>
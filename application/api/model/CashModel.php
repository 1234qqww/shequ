<?php

namespace app\api\model;
use think\Model;
class CashModel extends Model {
    protected $table='hhtc_cash';  //表名称

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
     * 申请提现记录
     */
    public function add($param){
        $data['money']=isset($param['money'])?$param['money']:'';
        $data['retail_id']=isset($param['retail_id'])?$param['retail_id']:'';
        $data['type']=isset($param['type'])?$param['type']:'';
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
        if(!empty($param['lng'])){
            $data['lng'] = $param['lng'];
        }
        if(!empty($param['lat'])){
            $data['lat'] = $param['lat'];
        }
        if(!empty($param['range'])){
            $data['range'] = $param['range'];
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
     * 获取所有分销商
     */
    public function distributor($param){
        $query=$this;
        if(!empty($param['key'])){
            $query->where('shopname','like',"%{$param['key']}%");
        }
        return $query->where('apply',1)->select();
    }
    /**
     * 分销商详情
     */
    public function oneDatas($id){
        return $this->where('id',$id)->find();
    }
    /**
     *
     */
}
?>
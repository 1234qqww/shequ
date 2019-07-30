<?php

namespace app\admin\model;
use think\Model;
class CashModel extends Model {
    protected $table='hhtc_cash';  //表名称

    /**
     * 申请列表
     */
    public function cashlists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $key = $param['key'];
            $query = $query->hasWhere(
                'retail',function($query) use ($key){
                    $query->where('shopname','like',"%{$key}%");
            }
            );
        }
        $data=$query->with('retail')->where('type',$param['type'])->page($page)->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 通过审核
     */
    public function adopt($param){
        return $this->where('id',$param['id'])->update(['type'=>$param['type'],'updated_at'=>date('Y-m-d H:i:s')]);
    }
    /**
     *驳回申请
     */
    public function reject($param){
        return $this->where('id',$param['id'])->delete();
    }
    /**
     * 关联分销商表
     */
    public function retail(){
        return $this->hasOne('app\admin\model\RetailModel','id','retail_id');
    }
    /**
     * 提现详情
     */
    public function onedata($id){
        return $this->where('id',$id)->find();
    }
}
?>
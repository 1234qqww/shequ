<?php

namespace app\admin\model;
use think\Model;
class IntegralClassModel extends Model {
    protected $table='hhtc_integralclass';  //表名称

    /**
     * 分类全部数据
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('integralclass','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 添加积分分类
     */
    public function add($param){
        $data['integralclass']=isset($param['integralclass'])?$param['integralclass']:'';
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
        if(!empty($param['integralclass'])){
            $data['integralclass'] = $param['integralclass'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
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
}
?>
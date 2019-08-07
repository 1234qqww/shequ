<?php

namespace app\admin\model;
use think\Model;
class TrandModel extends Model {
    protected $table='hhtc_trand';  //表名称

    /**
     * 动态全部数据
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('trand','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 添加动态
     */
    public function add($param){
        $data['trand']=isset($param['trand'])?$param['trand']:'';
        $data['images']=isset($param['images'])?$param['images']:'';
        $data['read']=isset($param['read'])?$param['read']:'';
        $data['thumbs']=isset($param['thumbs'])?$param['thumbs']:'';
        $data['good_id']=isset($param['good_id'])?$param['good_id']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 动态详情
     */
    public function onedata($id){
        return $this->get($id);
    }
    /**
     * 修改动态
     */
    public function edit($param){
        if(!empty($param['trand'])){
            $data['trand'] = $param['trand'];
        }
        if(!empty($param['images'])){
            $data['images'] = $param['images'];
        }
        if(!empty($param['read'])){
            $data['read'] = $param['read'];
        }
        if(!empty($param['thumbs'])){
            $data['thumbs'] = $param['thumbs'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
        return $this->where('id',$param['id'])->update($data);
    }
    /**
     * 删除动态
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
}
?>
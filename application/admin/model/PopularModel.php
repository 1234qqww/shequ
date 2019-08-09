<?php

namespace app\admin\model;
use think\Model;
class PopularModel extends Model {
    protected $table='hhtc_popular';  //表名称

    /**
     * 词汇全部数据
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('popular','like',"%{$param['key']}%");
        }
        $data=$query->page($page)->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 添加词汇
     */
    public function add($param){
        $data['popular']=isset($param['popular'])?$param['popular']:'';
        $data['sort']=isset($param['sort'])?$param['sort']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 词汇详情
     */
    public function onedata($id){
        return $this->get($id);
    }
    /**
     * 修改词汇
     */
    public function edit($param){
        if(!empty($param['popular'])){
            $data['popular'] = $param['popular'];
        }
        if(!empty($param['sort'])){
            $data['sort'] = $param['sort'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
        return $this->where('id',$param['id'])->update($data);
    }
    /**
     * 删除词汇
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 词汇的全部数据
     */
    public function subjectall(){
        return $this->order('sort','Desc')->limit(10)->select();
    }
}
?>
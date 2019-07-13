<?php

namespace app\admin\model;
use think\Model;
class TopicModel extends Model {
    protected $table='httc_topic';  //表名称

    /**
     * 标题全部数据
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('head','like',"%{$param['key']}%");
        }
        $data=$query->with('subject')->with('shop')->page($page)->limit($limit)->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 添加话题
     */
    public function add($param){
        $data['head']=isset($param['head'])?$param['head']:'';
        $data['picture']=isset($param['picture'])?$param['picture']:'';
        $data['image']=isset($param['image'])?$param['image']:'';
        $data['author']=isset($param['author'])?$param['author']:'';
        $data['content']=isset($param['content'])?$param['content']:'';
        $data['browse']=isset($param['browse'])?$param['browse']:'';
        $data['goods_id']=isset($param['goods_id'])?$param['goods_id']:'';
        $data['sid']=isset($param['sid'])?$param['sid']:'';
        $data['headimg']=isset($param['headimg'])?$param['headimg']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 关联话题分类
     */
    public function subject(){
        return $this->hasOne('SubjectModel','id','sid');
    }
    /**
     * 关联商品
     */
    public function shop(){
        return $this->hasOne('Goods','id','goods_id');
    }
    /**
     * 分类详情
     */
    public function onedata($id){
        return $this->get($id);
    }
//    /**
//     * 修改分类
//     */
//    public function edit($param){
//        if(!empty($param['title'])){
//            $data['title'] = $param['title'];
//        }
//        $data['updated_at']=date('Y-m-d H:i:s');;
//        return $this->where('id',$param['id'])->update($data);
//    }
//    /**
//     * 删除分类
//     */
//    public function del($id){
//        return $this->where('id',$id)->delete();
//    }
}
?>
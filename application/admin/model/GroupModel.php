<?php

namespace app\admin\model;
use think\Model;
use think\Session;

class GroupModel extends Model {
    protected $table='hhtc_group';  //表名称

    /**
     * 分销商品列表
     */
    public function lists($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $key = $param['key'];
            $query = $query->hasWhere(
                'good',function($query) use ($key){
                    $query->where('goods_name','like',"%{$key}%");
            }
            );
        }
        $data=$query->with('good')->page($page)->limit($limit)->order('id','Desc')->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 关联商品表
     */
    public function good(){
        return $this->hasOne('Goods','id','goods_id');
    }
    /**
     * 添加拼团商品
     */
    public function add($param){
        $data['goods_id']=isset($param['goods_id'])?$param['goods_id']:'';
        $data['price']=isset($param['price'])?$param['price']:'';
        $data['strikenum']=isset($param['strikenum'])?$param['strikenum']:'';
        $data['num']=isset($param['num'])?$param['num']:'';
        $data['regiment']=isset($param['regiment'])?$param['regiment']:'';
        $data['times']=isset($param['times'])?$param['times']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 商品详情
     */
    public function oneData($id){
        return $this->where('id',$id)->find();
    }
    /**
     * 修改商品
     */
    public function edit($param){
        if(isset($param['goods_id'])){
            $data['goods_id'] = $param['goods_id'];
        }
        if(isset($param['price'])){
            $data['price'] = $param['price'];
        }
        if(isset($param['strikenum'])){
            $data['strikenum'] = $param['strikenum'];
        }
        if(isset($param['num'])){
            $data['num'] = $param['num'];
        }
        if(isset($param['regiment'])){
            $data['regiment'] = $param['regiment'];
        }
        if(isset($param['times'])){
            $data['times'] = $param['times'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
        return $this->where('id',$param['id'])->update($data);
    }
    /**
     * 删除分销商品
     */
    public function del($id){
        return $this->where('id',$id)->delete();
    }
    /**
     * 查看团购商品是否存在
     */
    public function existence($goods_id){
        return $this->where('goods_id',$goods_id)->find();
    }



}
?>
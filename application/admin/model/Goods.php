<?php


namespace app\admin\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    protected $table='hhtc_goods';  //表名称
    //商品列表
    public function goods($where){
      return Db::name('goods')->where($where)->order('sort desc')->paginate(15);
    }

    //添加商品
    public function goods_add($data){

    return   Db::name('goods')->insertGetId($data);

    }

    //删除商品
    public function del_commodity($id,$state){

      return  Db::name('goods')->where($id)->data(['state'=>$state])->update();

    }
    /**
     * 全部数据
     */
    public function goodshops($param){
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query->where('goods_name','like',"%{$param['key']}%");
        }

        $data=$query->where('is_on_sale',1)->page($page)->limit($limit)->select();
        return ['data'=>$data,'count'=>count($data)];
    }
    /**
     * 商品详情
     */
    public function onedata($id){
        return $this->where('id',$id)->find();
    }


}
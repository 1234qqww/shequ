<?php


namespace app\api\controller;


use app\api\model\SelfshopModel;
use think\Db;
use think\Request;

class Commodity extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->subject= new Subject();
        $this->selfshop=new SelfshopModel();
    }

    public function index(){
        $param=$this->request->param();
        unset($param['token']);
        $where=array('is_show'=>1,'parent_id'=>0);
        $category=Db::name('good_category')->where($where)->order('sort_order asc')->select();
        foreach ($category as $k=>$v){
            $category[$k]['categorys']=$this->selectCategory($v['id']);
        }
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$category));
    }

    function selectCategory($id){
        $categorys=Db::name('good_category')->where(['parent_id'=>$id,'is_show'=>1])->select();
        foreach ($categorys as $k=>$v){
                $categorys[$k]['childs']=Db::name('good_category')->where(['parent_id'=>$v['id'],'is_show'=>1])->select();
        }
        return $categorys;
    }

    /**
     * 查看商品的第三级分类
     */
    public function shopclass(Request $request){
        $param=$request->param();
        if(!$param['user_id'] && !$param['retail_id']){
            return  json(array('code'=>2,'msg'=>'缺少参数','data'=>''));
        }
        unset($param['token']);
        $where=array('is_show'=>1,'level'=>3);
        $category=Db::name('good_category')->where($where)->order('sort_order asc')->select();
        foreach($category as $k=>$val){
            $where=['goods_category_id'=>$val['id']];
            $categorys=Db::name('goods')->where($where)->order('id asc')->select();
            $dats=$this->selfshop->ifs($param);
            foreach($categorys as $s=>$vals){
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$vals['original_img'])){
                    $categorys[$s]['original_img']=$this->subject->nowUrl(). $vals['original_img'];
                }
                if(!empty($dats)){
                    $arr=json_decode($dats->ids);
                    foreach($arr as $d=>$h){
                        if($vals['id']==$h){
                            $categorys[$s]['status']=true;
                        }
                    }
                }
            }
            $category[$k]['goods']=$categorys;
        }
        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$category));
    }
//    /**
//     * 查看分类下的商品
//     */
//    public function shopdet(Request $request){
//        $param=$request->param();
//        unset($param['token']);
//        $data=[];
//        foreach(json_decode($param['goods_category_id']) as $k=>$val){
//            $where=['goods_category_id'=>$val];
//            $category=Db::name('goods')->where($where)->order('id asc')->select();
//            foreach($category as $k=>$val){
//                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$val['original_img'])){
//                    $category[$k]['original_img']=$this->subject->nowUrl(). $val['original_img'];
//                }
//            }
//            $data[$k]=$category;
//        }
//
//        return  json(array('code'=>1,'msg'=>'查询成功','data'=>$data));
//    }




}
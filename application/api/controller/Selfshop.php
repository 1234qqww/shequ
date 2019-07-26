<?php


namespace app\api\controller;


use app\api\model\RetailModel;
use app\api\model\MagicModel;
use app\api\model\SelfshopModel;
use think\Controller;
use think\Db;
use think\Request;

class Selfshop extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->selfshop=new SelfshopModel();
        $this->retail=new RetailModel();
        $this->subject=new Subject();
        $this->magic=new MagicModel();
    }
    /**
     * 分销商添加商品
     */
    public function selfadd(Request $request){
        $param=$request->param();
        $selfshop=$this->selfshop->ifs($param);
        if(empty($selfshop)){
            $dat=explode(',',$param['ids']);
            array_pop($dat);
            $param['ids']=json_encode($dat);
            $data=$this->selfshop->add($param);
        }else{
            $arr=explode(',',$param['ids']);
            array_pop($arr);
            $param['ids']=json_encode($arr);
            $data=$this->selfshop->edit($param);
            return $data?json(['code'=>0,'msg'=>'修改成功','data'=>'']):json(['code'=>1,'msg'=>'修改失败','data'=>'']);
        }
        return $data?json(['code'=>0,'msg'=>'添加成功','data'=>'']):json(['code'=>1,'msg'=>'添加失败','data'=>'']);
    }
    /**
     * 分销商 商品
     */
    public function subjectshop(Request $request){
        $param=$request->param();
        $shelfshop=$this->selfshop->ifs($param);
        $ids=json_decode($shelfshop->ids);
        $good=[];
        foreach($ids as $k=>$val){
            $where=[];
            $order=[];
            $time=[];
            if(isset($param['prom_type']) && $param['prom_type']!=''){
                $where=['prom_type'=>$param['prom_type']];
            }

            $goods=Db::name('goods')->where('id',$val)->where($where)->order('id asc')->find();
            if(!empty($goods)){
                if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$goods['original_img'])){
                    $goods['original_img']=$this->subject->nowUrl(). $goods['original_img'];
                }
                $good[$k]=$goods;
            }else{
                $good=[];
            }

        }
        if(isset($param['time']) ){
            $last_names = array_column($good,'on_time');
            array_multisort($last_names,SORT_DESC,$good);
        }
        if(isset($param['price']) ){
            $last_names = array_column($good,'shop_price');
            if($param['orientation']=='true'){
                array_multisort($last_names,SORT_DESC,$good);
            }else{
                array_multisort($last_names,SORT_ASC,$good);
            }

        }
        if(isset($param['sales_sum']) ){
            $last_names = array_column($good,'sales_sum');
            if($param['sales']=='true'){
                array_multisort($last_names,SORT_DESC,$good);
            }else{
                array_multisort($last_names,SORT_ASC,$good);
            }
        }

        return $good?json(['code'=>0,'msg'=>'分销商品','data'=>$good]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 查看分销商信息
     */
    public function retails($id){
        $data=$this->retail->oneDatas($id);
        return $data?json(['code'=>0,'msg'=>'分销商','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    public function images(){
        $magic=$this->magic->onedata();
        $pic_list=json_decode($magic->magic,true);
        $this->MergePictures($pic_list);
    }
    public function ff(){
        $magic=$this->magic->onedata();
        return $magic?json(['code'=>0,'msg'=>'魔方图','data'=>$magic->magic_img]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }

}
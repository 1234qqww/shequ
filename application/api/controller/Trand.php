<?php
namespace app\api\controller;


use app\api\model\TrandcommentModel;
use app\api\model\TrandgiveModel;
use app\api\model\TrandModel;
use app\api\model\Good;
use think\Controller;
use think\Db;
use think\Request;

class Trand extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->trand=new TrandModel();
        $this->good=new Good();
        $this->subject=new Subject();
        $this->trandgive=new TrandgiveModel();
        $this->trandcomment=new TrandcommentModel();
    }

    /**
     * 是否点赞动态
     */
    public function trands(Request $request){
        $param =$request->param();
        $data=$this->trandgive->sel($param);
        return $data?json(['code'=>0,'msg'=>'已点赞','data'=>$data]):json(['code'=>1,'msg'=>'未点赞','data'=>$data]);
    }

    public function trandlist(Request $request){
        $param =$request->param();
        $data=$this->trand->trandlist();
        foreach($data as $k=>$val){
            $data[$k]->created_at=$this->time_ago(strtotime($data[$k]->created_at));
            $dat=$this->good->oneData($val->good_id);
            $dats['user_id']=$param['user_id'];
            $dats['trand_id']=$val->id;
            $trandgive=$this->trandgive->sel($dats);
            if($trandgive){
                $data[$k]->is_like=true;
            }else{
                $data[$k]->is_like=false;
            }
            if(!preg_match("/(http|https):\/\/([\w.]+\/?)\S*/",$dat['pic'])){
                $dat['pic']=$this->subject->nowUrl().$dat['pic'];
            }
            $data[$k]->images= explode(',',$val->images);
            $data[$k]->good=$dat;
        }
        return $data?json(['code'=>0,'msg'=>'全部动态','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>$data]);
    }

    /**
     * 计算时间
     */
    function time_ago($agoTime)
    {
        $agoTime = (int)$agoTime;

        // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
        $time = time() - $agoTime;

        if ($time >= 31104000) { // N年前
            $num = (int)($time / 31104000);
            return $num.'年前';
        }
        if ($time >= 2592000) { // N月前
            $num = (int)($time / 2592000);
            return $num.'月前';
        }
        if ($time >= 86400) { // N天前
            $num = (int)($time / 86400);
            return $num.'天前';
        }
        if ($time >= 3600) { // N小时前
            $num = (int)($time / 3600);
            return $num.'小时前';
        }
        if ($time > 60) { // N分钟前
            $num = (int)($time / 60);
            return $num.'分钟前';
        }
        return '1分钟前';
    }
    /**
     * 点赞
     */
    public function trandgive(Request $request){
        $param =$request->param();
        $trandgive=$this->trandgive->sel($param);
        if($trandgive){
            $data=$this->trandgive->del($param);
//            $trand=$this->trand->ondData($param['trand_id']);
//            $dat['read']=$trand->read-1;
//            $dat['trand_id']=$param['trand_id'];
//            $this->trand->editread($dat);
            return $data?json(['code'=>0,'msg'=>'取消点赞','data'=>$data]):json(['code'=>1,'msg'=>'失败','data'=>$data]);
        }else{
            $trand=$this->trand->ondData($param['trand_id']);
            $dat['read']=$trand->read+1;
            $dat['trand_id']=$param['trand_id'];
            $this->trand->editread($dat);
            $data=$this->trandgive->add($param);
            return $data?json(['code'=>0,'msg'=>'点赞成功','data'=>$data]):json(['code'=>1,'msg'=>'失败','data'=>$data]);
        }

    }
    /**
     * 添加阅读量
     */
    public function userread(Request $request){
        $param=$request->param();
        $trand=$this->trand->ondData($param['trand_id']);
        $dat['read']=$trand->read+1;
        $dat['trand_id']=$param['trand_id'];
        $this->trand->editread($dat);
    }
    /**
     * 评论动态
     */
    public function comment(Request $request){
        $param=$request->param();
        $trandcomment=$this->trandcomment->comment($param['trand_id']);
        foreach($trandcomment as $k=>$val){
            $trandcomment[$k]->replylist=$this->trandcomment->cidcomment($val->trand_id,$val->id);
        }
        return $trandcomment?json(['code'=>0,'msg'=>'评论列表','data'=>$trandcomment]):json(['code'=>1,'msg'=>'无数据','data'=>$trandcomment]);
    }
    /**
     * 添加动态评论
     */
    public function commentadd(Request $request){
        $param=$request->param();
        $data=$this->trandcomment->add($param);
        return $data?json(['code'=>0,'msg'=>'评论列表','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>$data]);
    }
    /**
     * 某条评论下的评论
     */
    public function commentdet(Request $request){
        $param=$request->param();
        $data=$this->trandcomment->oneData($param['id']);
        $data['replylist']=$this->trandcomment->cidcomment($data->trand_id,$data->id);
        return $data?json(['code'=>0,'msg'=>'评论列表','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>$data]);
    }

}
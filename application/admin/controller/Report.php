<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\ReportModel;
use think\Session;

class Report extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->report=new ReportModel();
    }

    public function report(){
        return $this->fetch('index');
    }
    public function reports(Request $request){
        $param=$request->param();
        $param['store_id']=session('good');
        $data=$this->report->see($param);
        if($data){
            if($data){
                $data=array_reverse($data->toArray());
            }else{
                $data=[];
            }
            foreach ($data as $k=>$val){
                $data[$k]['h']=date('H',strtotime($val['created_at']));
                if($k>0){
                    if(strtotime($data[$k-1]['created_at'])+180>strtotime($val['created_at'])){
                        $data[$k]['time']='';
                    }else{
                        if($data[$k]['h']>12) {
                            $data[$k]['time'] = '下午 '.date('H:i', strtotime($val['created_at']));
                        }else{
                            $data[$k]['time'] = '上午 '.date('H:i', strtotime($val['created_at']));
                        }
                    }
                }else{
                    if($data[$k]['h']=12) {
                        $data[$k]['time'] = '下午 '.date('H:i', strtotime($val['created_at']));
                    }else{
                        $data[$k]['time'] = '上午 '.date('H:i', strtotime($val['created_at']));
                    }
                }

            }

            $this->assign('info',$data);
            $this->assign('store_id',  $param['store_id']);
            $this->assign('user_id',  $param['user_id']);
        }
        return $this->fetch('report');
    }
    /**
     * 店铺全部消息
     */
    public function storelists(Request $request){
        $param=$request->param();
        $param['goods_id']=session('good');
        if(!empty($param['goods_id'])){
            $report=$this->report->storelists($param);
            $data=$report['data']->toArray();
            return $data?['code'=>0,'msg'=>'消息列表','data'=>$data]:['code'=>1,'msg'=>'无数据','data'=>''];
        }
    }
    /**
     * 查看消息
     */
    public function see(Request $request){
        $param=$request->param();
        $data=$this->report->see($param);
        if($data){
            $data=array_reverse($data->toArray());
        }else{
            $data=[];
        }
        foreach ($data as $k=>$val){
            $data[$k]['h']=date('H',strtotime($val['created_at']));
            if($k>0){
                if(strtotime($data[$k-1]['created_at'])+180>strtotime($val['created_at'])){
                    $data[$k]['time']='';
                }else{
                    if($data[$k]['h']>12) {
                        $data[$k]['time'] = '下午 '.date('H:i', strtotime($val['created_at']));
                    }else{
                        $data[$k]['time'] = '上午 '.date('H:i', strtotime($val['created_at']));
                    }
                }
            }else{
                if($data[$k]['h']=12) {
                    $data[$k]['time'] = '下午 '.date('H:i', strtotime($val['created_at']));
                }else{
                    $data[$k]['time'] = '上午 '.date('H:i', strtotime($val['created_at']));
                }
            }

        }

        return $data?json_encode(['code'=>0,'msg'=>'消息列表','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','data'=>'']);
    }
    /**
     * 店铺添加消息
     */
    public function store(Request $request){
        $param=$request->param();
        $data=$this->report->add($param);
        return $data?json_encode(['code'=>0,'msg'=>'发送成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'发送失败','data'=>'']);
    }
    /**
     * 把消息改为已读
     */
    public function readstore(Request $request){
        $param=$request->param();
        $report=$this->report->readstore($param);
        foreach($report as $k=>$val){
            $this->report->already($val->id);
        }
        return $report?json_encode(['code'=>0,'msg'=>'成功','']):json_encode(['code'=>1,'msg'=>'失败','']);

    }
}
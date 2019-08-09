<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\ReportModel;
use think\Session;

class Report extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->report=new ReportModel();
        $this->subject=new Subject();
    }
    /**
     * 查看消息
     */
    public function retailsee(Request $request){
        $param=$request->param();
        $data=$this->report->retailsee($param);
        if($data){
            $data=array_reverse($data->toArray());
        }else{
            $data=[];
        }
        foreach ($data as $k=>$val){
            $data[$k]['h']=date('H',strtotime($val['created_at']));
            if(!empty($data[$k]['goods'])){
                $data[$k]['goods']['pic']=$this->subject->nowUrl(). $data[$k]['goods']['pic'];
            }

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
     * 店铺或者分销商添加消息
     */
    public function store(Request $request){
        $param=$request->param();
        $data=$this->report->add($param);
        return $data?json_encode(['code'=>0,'msg'=>'发送成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'发送失败','data'=>'']);
    }
    /**
     * 把消息改为已读  店铺
     */
    public function readstore(Request $request){
        $param=$request->param();
        $report=$this->report->readstore($param);
        foreach($report as $k=>$val){
            $this->report->already($val->id);
        }
        return $report?json_encode(['code'=>0,'msg'=>'成功','']):json_encode(['code'=>1,'msg'=>'失败','']);

    }
    /**
     * 把消息改为已读  分销商
     */
    public function readretail(Request $request){
        $param=$request->param();
        $report=$this->report->readretail($param);
        foreach($report as $k=>$val){
            $this->report->already($val->id);
        }
        return $report?json_encode(['code'=>0,'msg'=>'成功','']):json_encode(['code'=>1,'msg'=>'失败','']);
    }
    /**
     * 查看是分销商的消息列表
     */
    public function reseller(Request $request){
        $param=$request->param();
        $data=$this->report->storelists($param,1);
        foreach($data as $k=>&$val){
            $data[$k]=$this->report->last($val->user_id,$val->retail->id,1);
            $data[$k]['newnums']=$val->count;
        }

        return $data?json_encode(['code'=>0,'msg'=>'成功','data'=>$data]):json_encode(['code'=>1,'msg'=>'失败','']);
    }
    /**
     * 查看用户的全部消息
     */
    public function allnews(Request $request){
        $param=$request->param();
        $allnews=$this->report->allnews($param,0);
        if($allnews){
            foreach($allnews as $k=>$val){
                $allnews[$k]=$this->report->last($val->user_id,$val->retail->id,1);
                $allnews[$k]['newnums']=$val->count;
            }
        }

        $allstores=$this->report->allstore($param,0);
        if($allstores){
            foreach($allstores  as $k=>&$val){
                $allstores[$k]=$this->report->storelast($val->user_id,$val->goods->id,0);
                $allstores[$k]['newnums']=$val->count;
            }
        }
        $data=array(
            'allnews'=>$allnews,
            'allstore'=>$allstores
        );
        return $data?json_encode(['code'=>0,'msg'=>'全部消息','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','']);
    }
    /**
     * 用户所有的未读消息
     */
    public function readreport(Request $request){
        $param=$request->param();
        $data=$this->report->readreport($param);
        return $data?json_encode(['code'=>0,'msg'=>'未读消息','data'=>$data]):json_encode(['code'=>1,'msg'=>'没数据','data'=>0]);
    }

}
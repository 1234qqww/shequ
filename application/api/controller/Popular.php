<?php
namespace app\api\controller;
use app\admin\model\PopularModel;
use think\Db;
use think\Request;

class Popular extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->popular=new PopularModel();

    }
    /**
     * 热门搜索
     */
    public function popular(){
        $data=$this->popular->subjectall();
        return $data?json_encode(['code'=>0,'msg'=>'全部热门词汇','data'=>$data]):json_encode(['code'=>1,'msg'=>'无数据','']);
    }
}
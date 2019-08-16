<?php
namespace app\api\controller;


use app\api\model\CommentModel;
use think\Request;

class Comment extends Base
{
    private $comment;
    public function _initialize()
    {
        $this->comment=new CommentModel();
    }

    /**
     * 添加评论
     */
    public function comment(Request $request){
        $param=$request->param();
        $data=$this->comment->add($param);
        return $data?json(['code'=>0,'msg'=>'评论成功','data'=>$data]):json(['code'=>1,'msg'=>'失败','data'=>'']);
    }
    /**
     * 查看商品评论
     */
    public function goodComment(Request $request){
        $param=$request->param();
        $data=$this->comment->goodComment($param);
        return $data?json(['code'=>0,'msg'=>'评论数据','data'=>$data]):json(['code'=>1,'msg'=>'无数据','data'=>'']);
    }

}
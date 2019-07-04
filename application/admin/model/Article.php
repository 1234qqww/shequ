<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/3
 * Time: 15:45
 */

namespace app\admin\model;


use app\common\model\Base;
use think\Db;

class Article extends Base
{
    protected $autoWriteTimestamp = 'datetime';
    protected $updateTime = false;
    public function login(){
        return $this->hasMany('login','userid',"userid");
    }
    
    public function showList(){
        return Db::name('article')
            ->alias('a')
            ->join('login l','a.userid=l.userid')
            ->field('comments,username,content,contentdown,contentup,contentid,a.create_time,orders,userimg,title,a.state')
            ->where([
                'a.state'=>'normal'
            ])
            ->order('orders','desc')
            ->paginate();
    }
}
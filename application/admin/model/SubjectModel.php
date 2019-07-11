<?php

namespace app\admin\model;

use think\Db;
class SubjectModel extends Model {
    protected $table='subject';  //表名称

    /**
     * @return array
     * 查询全部数据
     */
    public function lists(){
        $param=input('param.');
        $page = empty($param['page'])?0:$param['page'];
        $limit = empty($param['limit'])?20:$param['limit'];
        $query=$this;
        if(!empty($param['key'])){
            $query = $query -> where('title','like',"%{$param['key']}%");
        }
        $offset = ($page-1)*$limit;
        $count=$query->select()->count;
        $data=$query->offset($offset)->limit($limit)->select();
        return ['data'=>$data,'count'=>$count];
    }
}
?>
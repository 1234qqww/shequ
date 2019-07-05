<?php
/**
 * Created by IntelliJ IDEA.
 * User: yvdedu.com
 * Date: 2018/12/26
 * Time: 12:53
 */

namespace app\common\model;


use think\Model;
use traits\model\SoftDelete;

class Base extends Model
{


    /**
     * 根据有Id修改信息 无Id 新增信息
     * @param $data
     * @return false|int|string
     * @throws
     */
    public function editData($data,$id){
        //判断id是否设置
        if (isset($data[$id])){
            //判断参数id是否是数字
            if (is_numeric($data[$id]) && $data[$id]>0){
                //过滤非字段表的字段，修改信息
                $save = $this->allowField(true)->save($data,[ $id => $data[$id]]);
            }else{
                //过滤非字段表的字段，新增信息
                $save  = $this->allowField(true)->save($data);
            }
        }else{
            //过滤非字段表的字段，新增信息
            $save  = $this->allowField(true)->save($data);
        }
        if ($save == 0 || $save == false)
            return ['code'=>'1030','msg'=>'数据操作失败'];
        else
            return  ['code'=>'1001','msg'=>'操作成功'];
    }
    /**
     * 通过查询条件获取单条数据(数组)
     * @param array $map
     * @param bool|true $field
     * @param array $append
     * @return array
     */

    public function getArrayByMap($map=[],$field=true,$append=[]){
        $object = $this->where($map)->field($field)->find();
        if(!empty($object)&&!empty($append)){
            $return = $object->append($append);
        }else{
            $return = $object;
        }
        return empty($return) ? ['code'=>'1006','msg'=>'数据加载失败'] : ['code'=>'1001','msg'=>'操作成功','data'=>$return->toArray()];
    }

    /**
     * 通过查询条件获取多条数据(数组)
     * @param array $map
     * @param bool|true $field
     * @param array $append 这需要在模型里增加获取器
     * @return array
     */
    public function getListByMap($map=[],$field=true,$append=[]){
        $object_list = $this->where($map)->field($field)->select();
        $list=[];
        if(!empty($object_list)){
            foreach($object_list as $item=>$value){
                if(!empty($append)){
                    $list[]= $value->append($append)->toArray();
                }else{
                    $list[]= $value->toArray();
                }
            }
        }
        return $list;
    }
//    /**
//     * 通过查询条件获取多条数据(数组)
//     * @param array $map
//     * @param bool|true $field
//     * @param array $append 这需要在模型里增加获取器
//     * @return array
//     */
    public function getListOdByMap($map=[],$field=true,$append=[]){
        $object_list = $this->where($map)->field($field)->order($append)->select();
        return  $object_list;
    }

    /**
     * 分页，排序
     */
    public function getpageByMap($map=[],$field=true,$append=null){
        $object_page=$this->where($map)->field($field)->paginate(20);
        return $object_page;

    }

    /**
     * 分页，排序带条件排序
     */
    public function getpageOdByMap($map=[],$field=true,$append=null){
        $object_page=$this->where($map)->field($field)->order($append)->paginate(15);
        return $object_page;

    }
        /**
     * 快速删除
     */
    public function getdelectByMap($map=[],$field=true,$append=null){
       $boolean= $this->where($map)->delete();
        return $boolean;
    }
    /**
     * 多表关联，返回多条数据
     */
    public function getLinkedList($map=[],$field=true,$append=null){
        $list=$this->with($append)->where($map)->field($field)->paginate(15);
        return $list;
    }
    /**
     * 多表关联，返回单条数据
     */
    public function getOneList($map=[],$field=true,$append=null){
        $list=$this->with($append)->where($map)->field($field)->find();
        return $list;
    }
    /**
     * 批量导入
     */
    public function saveAlls($map=[]){
       $all=$this->saveAll($map);
        return $all;
    }
    public function getLinkPageList($map=[],$field=true,$append=null){
        $list=$this->with($append)->where($map)->field($field)->paginate(15);
        return $list;
    }
    /**
     * 批量删除
     */
//    public function delAll($map=[]){
//      $boolean=$this->;
//      return $boolean;
//    }
    public function success($msg){
        $res['code']='1';
        $res['msg']=$msg;
        return $res;
    }
    public function error($msg){
        $res['code']='0';
        $res['msg']=$msg;
        return $res;
    }
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: yzwedu.com
 * Date: 2019/6/16
 * Time: 15:56
 */

namespace app\admin\model;




use app\common\model\Base;
use think\Db;

class Slide extends Base
{
    public function getCreateTimeAttr($time)
    {
        return $time;
    }
    //轮播列表
    public function getListSlide(){
       return Db::name('slide')->order('order asc')->paginate(15);
    }
    //添加轮播
    public function add_banner($data){
        if($data['imgs']==''){
            return $this->error('请上传图片!');
        }
        if ($data['order']==''){
            return $this->error('请填写排序号!');
        }

        if(strpos($data['imgs'],'base64') !== false){
            $data['imgs']=base64toimg($data['imgs']);
        }
        if(isset($data['display'])){
            $data['display']=1;
        }else{
            $data['display']=0;
        }
        $data['create_time']=date('Y-m-d H:i:s');
        if(Db::name('slide')->insert($data)){
            return $this->success('添加成功!');
        }else{
            return $this->error('添加失败!');
        }

    }


    //修改轮播
    public function edit_banner($data){
        if($data['imgs']==''){
            return $this->error('请上传图片!');
        }
        if ($data['order']==''){
            return $this->error('请填写排序号!');
        }

        if(strpos($data['imgs'],'base64') !== false){
            $data['imgs']=base64toimg($data['imgs']);
        }
        if(isset($data['display'])){
            $data['display']=1;
        }else{
            $data['display']=0;
        }
        if(Db::name('slide')->update($data)){
            return $this->success('保存成功!');
        }else{
            return $this->error('没有改动!');
        }


    }


    //删除轮播
    public function del_banner($data){
        if(Db::name('slide')->delete($data)){
            return $this->success('删除成功!');
        }else{
            return $this->error('删除失败!');
        }
    }

}
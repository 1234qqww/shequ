<?php

namespace app\api\model;
use think\Model;
class MagicModel extends Model {
    protected $table='hhtc_magic';  //表名称

    public function onedata(){
        return $this->find();
    }
    /**
     * 添加魔方图片
     */
    public function add($param){
        $data['magic']=isset($param['magic'])?$param['magic']:'';
        $data['created_at']=date('Y-m-d H:i:s');
        $data['updated_at']=date('Y-m-d H:i:s');
        return $this->save($data);
    }
    /**
     * 修改图片
     */
    public function edit($param){
        if(!empty($param['magic'])){
            $data['magic'] = $param['magic'];
        }
        $data['updated_at']=date('Y-m-d H:i:s');;
        return $this->where('id',$param['id'])->update($data);
    }
}
?>
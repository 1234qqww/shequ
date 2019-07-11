<?php


namespace app\admin\model;


use think\Db;
use think\Model;

class GoodCategory extends Model
{
    /**
     * 获得指定分类下的子分类的数组
     * @access  public
     * @param   int     $cat_id     分类的ID
     * @param   int     $selected   当前选中分类的ID
     * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
     * @param   int     $level      限定返回的级数。为0时返回所有级数
     * @return  mix
     */

      public function goods_cat_list(){

          global $goods_category, $goods_category2;
          $sql = "SELECT * FROM  hhtc_good_category ORDER BY parent_id , sort_order ASC";
          $goods_category = DB::query($sql);
          $goods_category = $this->convert_arr_key($goods_category, 'id');
          foreach ($goods_category AS $key => $value)
          {
              if($value['level'] == 1)
                  $this->get_cat_tree($value['id']);
          }
          return $goods_category2;
      }

    function convert_arr_key($arr, $key_name)
    {
        $arr2 = array();
        foreach($arr as $key => $val){
            $arr2[$val[$key_name]] = $val;
        }
        return $arr2;
    }

    /**
     * 获取指定id下的 所有分类
     * @global type $goods_category 所有商品分类
     * @param type $id 当前显示的 菜单id
     * @return 返回数组 Description
     */
    public function get_cat_tree($id)
    {
        global $goods_category, $goods_category2;
        $goods_category2[$id] = $goods_category[$id];
        foreach ($goods_category AS $key => $value){
            if($value['parent_id'] == $id)
            {
                $this->get_cat_tree($value['id']);
                $goods_category2[$id]['have_son'] = 1; // 还有下级
            }

        }
    }


    public function arr_push($parent_id,$list){
     $good_category=Db::name('good_category')->where(['id'=>$parent_id])->find();

         if($good_category['parent_id']!=0){
             $list[]=$good_category['parent_id'];
             $list=$this->arr_push($good_category['parent_id'],$list);
         }
        return  $list;
    }


    function get_top_parentid($cate,$id){
        $arr=array();
        foreach($cate as $v){
            if($v['id']==$id){
                $arr[]=$v;
                $arr=array_merge(get_top_parentid($cate,$v['fid']),$arr);
            }
        }return $arr;

    }



}
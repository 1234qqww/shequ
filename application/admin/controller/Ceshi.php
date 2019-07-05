<?php


namespace app\admin\controller;


class Ceshi extends Base
{


    public function save_sku(){
        if(request()->isPost()){

            $data=request()->post();
            dump($data);die();
            $bool=ItemSku::where(['item_id'=>$data[0]['item_id']])->delete();
            console($bool);

            foreach ($data as $item) {
                $sku=new ItemSku();
                $sku->item_id=$item['item_id'];
                $sku->original_price=$item['original_price'];
                $sku->price=$item['price'];
                $sku->stock=$item['stock'];
                $sku->attr_symbol_path=$item['symbol'];
                $sku->save();
            }
        }
    }
    public function save_attr()
    {
        if (request()->isPost()) {
            $data = request()->post();
            dump($data);die();
            $key = json_decode($data['key'], true);
            $value = json_decode($data['value'], true);
            $item_id = 1;
            $key_id = [];
            ItemAttrKey::where(['item_id' => $item_id])->delete();
            foreach ($key as $k) {
                $attr_key = ItemAttrKey::where(['attr_name' => $k, 'item_id' => $item_id])->find();
                if (!$attr_key) {
                    $attr_key = new ItemAttrKey();
                    $attr_key->attr_name = $k;
                    $attr_key->item_id = $item_id;
                    $attr_key->save();
                }
                $key_id[] = $attr_key->attr_key_id;
            }
            $tm_v_in = [];
            $tm_v = [];
            ItemAttrVal::where(['item_id' => $item_id])->delete();
            foreach ($value as $key => $v) {
                $attr_key_id = $key_id[$key];
                foreach ($v as $v1) {
                    $attr_value = ItemAttrVal::where(['attr_value' => $v1, 'attr_key_id' => $attr_key_id])->find();
                    if (!$attr_value) {
                        $attr_value = new ItemAttrVal();
                        $attr_value->attr_key_id = $attr_key_id;
                        $attr_value->attr_value = $v1;
                        $attr_value->item_id = $item_id;
                        $attr_value->save();
                    }
                    $tm_v[] = $attr_value->symbol;
                }

            }

            $this->success('请求成功', ['key' => $key_id, 'value' => $tm_v]);
        }
        $this->success('请求成功');
    }

}
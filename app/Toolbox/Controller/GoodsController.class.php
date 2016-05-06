<?php
namespace Toolbox\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function updateBrandId(){
        $model_goods = D('goods');
        $model_goods_brand = D('goods_brand');

        $list_goods = $model_goods->select();

        foreach($list_goods as $key => $val) {
            $map['display'] = trim($val['brand_display']);
            $info_brand = $model_goods_brand->where($map)->find();
            if ($info_brand) {
                $val['brand_id'] = $info_brand['id'];
                var_dump('matchItem', $info_brand);
                $model_goods->save($val);
            } else {
                var_dump('disMatch', $info_brand, trim($val['brand_display']));
                $input = array(
                    'brandName' => $val['brand_display']
                );
                var_dump('Gear-R', R('Gear/Brand/addBrand', $input));
            }
        }

        //$map['display'] = $val['brand_display'];
        //$info_brand = $model_goods_brand->where($map)->find();
        //var_dump($model_goods->select());
    }
}
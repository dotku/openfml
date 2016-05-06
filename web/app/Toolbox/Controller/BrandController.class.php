<?php
namespace Gear\Controller;
use Think\Controller;
class BrandController extends Controller {
    public function caseClean(){
        $model = D('goods_brand');
        $list = $model->select();
        foreach($list as $key => $val) {
            $val['name'] = strtolower($val['name']);
            $model->save($val);
        }
        var_dump('after', $list = $model->select());
    }
    public function nameReset(){
        $model = D('goods_brand');
        $list = $model->select();
        foreach($list as $key => $val) {
            $val['name'] = strtolower($val['display']);
            $val['name'] = str_replace(' ', '-', $val['name']);
            $val['name'] = str_replace('\'', '', $val['name']);
            $model->save($val);
        }
        var_dump('after', $list = $model->select());
    }
}
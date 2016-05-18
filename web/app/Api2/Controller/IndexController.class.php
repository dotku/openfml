<?php
namespace Api2\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function _initialize(){
        $this->output = array();
    }
    public function index(){
        $white_list = array(
            'goods_brand',
            'goods_cate',
            'goods',
            'user'
        );
        if (in_array($_GET['table'], $white_list)) {

            switch (strtolower($_GET['table'])) {
                case 'user':
                    $this->_getUser();
                    break;
                case 'goods_cate':
                    if (!$_GET['has_goods']) {
                        $this->_default();
                    } else {
                        $this->_goods_cate_hasGoods();
                    }
                    break;
                default:
                    $this->_default();
            }
            echo json_encode($this->output);

        } else {
            // var_dump(in_array($_GET['table'], $white_list));
            echo 'Hello, Welcome to API 2!';
        }

    }

    public function _default(){
        //var_dump($_GET['table']);
        $model = D($_GET['table']);
        //var_dump($_GET['id']);
        if ($_GET['id']) {
            $map['id'] = intval($_GET['id']);
            $info = $model->where($map)->find();
            if ($info) {
                $this->output['data'] = $info;
                $this->output['status_code'] = 1;
            } else {
                $this->output['data'] = 'Either null or empty.';
                $this->output['status_code'] = -1;
            }
        } else {
            $list = $model->select();
            if (is_array($list) && !empty($list)) {
                $output['data'] = $list;
                $output['status_code'] = 1;
            } else {
                $output['data'] = 'Either null or empty.';
                $output['status_code'] = -1;
            }
        }
        $this->output = $output;
    }

    public function _getUser(){
        $model = D($_GET['table']);
        $list = $model->order('uid desc')->limit(1000)->select();
        if (is_array($list) && !empty($list)) {
            foreach($list as $key => $value) {
                unset($list[$key]['password']);
                unset($list[$key]['salt']);
            }
            $output['data'] = $list;
            $output['status_code'] = 1;
        } else {
            $output['data'] = 'Either null or empty.';
            $output['status_code'] = -1;
        }
        echo json_encode($output);
    }
    public function _goods_cate_hasGoods(){
        $model_goods = D('goods');
        $model_goods_cate = D('goods_cate');
        $output_cate_list = array();

        $group_goods = $model_goods->group('cate_id')->select();
        foreach($group_goods as $key => $val) {
            $map['id'] = $val['cate_id'];
            $info_goods_cate = $model_goods_cate->where($map)->find();
            array_push($output_cate_list, $info_goods_cate);
        }
        $this->output = $output_cate_list;
    }
    public function jsonp(){

    }
}
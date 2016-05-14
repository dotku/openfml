<?php
namespace Api2\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function _initialize(){

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
                default:
                    $model = D($_GET['table']);
                    //var_dump($_GET['id']);
                    if ($_GET['id']) {
                        $map['id'] = intval($_GET['id']);
                        $info = $model->where($map)->find();
                        if ($info) {
                            $output['data'] = $info;
                            $output['status_code'] = 1;
                        } else {
                            $output['data'] = 'Either null or empty.';
                            $output['status_code'] = -1;
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
                    echo json_encode($output);
            }

        } else {
            //var_dump(in_array($_GET['table'], $white_list));
            echo 'Hello, Welcome to API 2!';
        }

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
    public function jsonp(){

    }
}
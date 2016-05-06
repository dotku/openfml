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
            'goods'
        );
        if (in_array($_GET['table'], $white_list)) {
            $model = D($_GET['table']);
            $list = $model->select();
            if (is_array($list) && !empty($list)) {
                $output['data'] = $list;
                $output['status_code'] = 1;
            } else {
                $output['data'] = 'Either null or empty.';
                $output['status_code'] = -1;
            }
            echo json_encode($output);
        } else {
            echo 'Hello, Welcome to API 2!';
        }
        
    }
    public function jsonp(){

    }
}
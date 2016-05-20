<?php
namespace Api2\Controller;
use Think\Controller;
class CartController extends Controller {
    public function index(){
        $model = D('cart');
        $list = D('cart')->where($_GET)->select();
        // var_dump($list

        if ($_GET['action'] == 'add') {
            $key = $this->_genCartTag(md5(time()));
            $list = D('cart')->where(array('cart_tag' => $key))->select();
        }

        if ($_GET['pretty']) {
            echo json_encode($list, JSON_PRETTY_PRINT);
        } else {
            echo json_encode($list);
        }
    }
    public function _genCartTag($key) {
        try {
            $model = D('cart');
            $data['cart_tag'] = $key ? $key : md5(time());
            $model->add($data);
            var_dump($key);
            return $data['cart_tag'];
        } catch (\Exception $e) {
            $this->_genCartTag(md5(time()));
        }
    }
    public function get_languages(){
        $model = D('settings_languages');
        //var_dump($model->select());
        echo json_encode($model->select());
    }
    public function set_language(){
        $_COOKIE['hl'] = $_REQUEST['hl'];
        //var_dump($_COOKIE);
        if ($_SESSION['user']) {
            // read settings
            $model = D('user');
            $map['id'] = $_SESSION['user']['id'];
            $row = $model->where($map)->find();
            
            // set options
            $options = unserialize($row['options']);
            $options['hl'] = $_REQUEST['hl'];
            
            // save options
            $row['options'] = $options;
            $model->save($row);
        }
    }
}
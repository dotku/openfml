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

    public function add(){
        $model = D('cart');
        $list = D('cart')->where($_GET)->select();
        // var_dump($_SESSION);
        // session_destroy();
        if (!$_SESSION['cart']['cart_key']) {
            $key = $this->_genCartTag(getHashKey());
            $_SESSION['cart']['cart_key'] = $key;
            $_SESSION['user']['username'] = 'guest_'.md5(time().mt_rand());
        } else {
            $key = $_SESSION['cart']['cart_key'];
            // var_dump($key);
        }
        
        $list = D('cart')->where(array('cart_key' => $key))->find();

        if ($_GET['pretty']) {
            echo json_encode($list, JSON_PRETTY_PRINT);
        } else {
            echo json_encode($list);
        }
    }

    public function _genCartTag($key) {
        try {
            $model = D('cart');
            $data['cart_key'] = $key ? $key : md5(time().mt_rand());
            $data['cart_key'] = 'cart_'.$data['cart_key'];
            // 为了支持 guest，这里使用 username 而不是 user_id
            $data['username'] = getUsername();
            
            $model->add($data);
            // var_dump($key);
            return $data['cart_key'];
        } catch (\Exception $e) {
            $this->_genCartTag(md5(time().mt_rand()));
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
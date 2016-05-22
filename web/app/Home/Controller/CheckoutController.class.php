<?php
namespace Home\Controller;
use Think\Controller;
class CheckoutController extends Controller {
  public function index(){
    if (!$_GET['cart_tag']) {
      $model_cart = D('cart');
      $model_cart_entry = D('entry');
      $data['cart_tag'] = md5(time());
      $model_cart->create($data);
      // $model_cart->add();
      // $this->redirect('/Home/Checkout/?cart_tag='.$cart_tag);
    }
    
    if ($_GET['goods_id']) {
      $model_goods = D('goods');
      $model_cart = D('cart');

      $list_goods = D('goods')->where($_GET)->select();
      if ($list_goods){
        foreach($list_goods as $key => $val) {
          $list_goods[$key]['quantity'] = 1;
        }
      } else {
        $this->error('no such goods is existed');

      }

      $data_cart['cart_key'] = getCartKey();
      $data_cart['goods'] = serialize($list_goods);
      $map_cart['cart_key'] = $data_cart['cart_key'];
      $model_cart->where($map_cart)->save($data_cart);

      // var_dump($list_goods);
      if (!$_SESSION['user']) {
        $cart['user_id'] = 'guest_'.time();
        $_SESSION['user']['id'] = $cart['user_id'];
      }
    }
    
    // $this->output = $output;
    $this->display();
  }

  public function sign_in(){
    if ($_POST){
      $model_user = D('user');
      $map_user['username'] = $_POST['username'];
      $map_user['password'] = md5($_POST['password']);
      $info_user = $model_user->where($map_user)->find();
      if ($info_user) {
        unset($info_user['password']);
        $_SESSION['user'] = $info_user;
        $this->redirect('Index/order');
      } else {
        // var_dump($_POST);
        // var_dump($info_user);
        $this->error('登陆失败');
      }
    } else{
      $this->display();
    }
  }

  public function logout(){
    session_destroy();
    $this->redirect('/index/sign_in');
  }

  public function profile(){
    $this->error('页面制作中，请稍后回来...');
  }
}
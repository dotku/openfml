<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
  public function index(){
    $model_cart = D('cart');
    $model_goods = D('goods');
    $map_cart['cart_key'] = $_SESSION['cart']['cart_key'];

    // 创建 购物车
    $info_cart = $model_cart->where($map_cart)->find();
    if (!$info_cart) {
      $model_cart->add($map_cart);
    }

    // 添加物品
    if ($_REQUEST['goods_id']) {
      $map_goods['goods_id'] = $_REQUEST['goods_id'];
      $info_goods = $model_goods->where($map_goods)->find();
      $info_cart = $model_cart->where($map_cart)->find();
      $cart_goods = unserialize($info_cart['goods']);

      if ($cart_goods && is_array($cart_goods)) {
        $is_found = true;
        foreach($cart_goods as $key => $val){
          if ($val)
        }
        if (!$is_found){
          // var_dump('not in the cart');
          array_push($info_goods, $cart_goods);
          // var_dump($cart_goods);
        } else {
          // var_dump('found the item in the cart');
          $key = array_search($info_goods, $cart_goods);
          $cart_goods[$key]['quantity']++;
        }
      } else {
          $cart_goods = array();
          array_push($cart_goods, $info_goods);
      }

      $info_cart['goods'] = serialize($cart_goods);
      $model_cart->save($info_cart);
    }

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
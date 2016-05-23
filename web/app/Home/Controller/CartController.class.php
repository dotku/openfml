<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
  public function index(){
    $model_cart = D('cart');
    $model_goods = D('goods');
    $map_cart['cart_key'] = getCartKey();

    // 导向 

    if (I('path.2')){
      cookie('cart_key', I('path.2'));
      $map_cart['cart_key'] = getCartKey();
    }
    // var_dump(I('path.2') != $map_cart['cart_key']);
    if (I('path.2') != $map_cart['cart_key']) {
      var_dump($map_cart['cart_key']);
      // redirect('/cart/index/' + $map_cart['cart_key']);
      $this->redirect('/Cart/index/'.$map_cart['cart_key']);
    }

    // 创建 购物车
    $info_cart = $model_cart->where($map_cart)->find();
    if (!$info_cart) {
      $model_cart->add($map_cart);
    }

    // 添加物品
    // var_dump($_REQUEST['goods_id']);
    if ($_REQUEST['goods_id']) {
      $map_goods['goods_id'] = $_REQUEST['goods_id'];
      $info_goods = $model_goods->where($map_goods)->find();
      $info_cart = $model_cart->where($map_cart)->find();
      $cart_goods = unserialize($info_cart['goods']);

      // var_dump((!empty($cart_goods) && is_array($cart_goods)));
      if (!empty($cart_goods) && is_array($cart_goods)) {
        foreach ($cart_goods as $key => $value) {
          if ($value['goods_id'] == $_REQUEST['goods_id']){
            $cart_goods[$key]['quantity'] ++;
            $is_found = true;
            break;
          } else {
            $is_found = false;
          }
        }
        // var_dump('expression');
        // var_dump(!$is_found && !empty($info_goods));
        if (!$is_found && $info_goods){
          // var_dump('not in the cart');
          array_push($cart_goods, $info_goods);
          // var_dump($cart_goods);
          // var_dump($info_goods);
          // var_dump(array_push($info_goods, $cart_goods));
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
  public function fork(){
    $model_cart = D('cart');
    var_dump(cookie('cart_key'));
    $map_cart['cart_key'] = cookie('cart_key');

    $data = $model_cart->where($map_cart)->find();
    unset($data['cart_id']);
    cookie('cart_key', null);
    $map_cart['cart_key'] = $data['cart_key'] = getCartKey();
    var_dump($data);
    $model_cart->where($map_cart)->save($data);
    
    var_dump(getCartKey());
    $this->redirect('/Cart/index/'.$map_cart['cart_key']);
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
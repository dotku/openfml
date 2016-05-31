<?php
/**
 * 购物车
 * 
 * 1. 购物车有分为两种，一种公有的，一种私有的
 * 2. 每个人可以拥有多辆的购物车
 * 3. 默认下访问的是用户最近使用的购物车
 * 4. 游客的购物车可以被访问
 * 每个人所拥有的购物车应该是独一无二的
 * 通过 /cart/user/username/cart_key 来访问个人的购物车
 * ** 注意，购物车在 Common/function 中还有在使用，之后将废弃，通过 
 * R("Cart/getCartKey") 来实现
 * 
 */ 
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller {
  public function index(){
    $model_cart = D('cart');
    $model_goods = D('goods');
    $map_cart['cart_key'] = getCartKey();

    // 添加物品
    // var_dump($_REQUEST['goods_id']);
    if ($_REQUEST['goods_id']) {
      $map_goods['goods_id'] = $_REQUEST['goods_id'];
      $info_goods = $model_goods->where($map_goods)->find();
      $info_goods['quantity']++;
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

    

    $this->display('index');
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


  public function getCartKey(){
    if ($_GET['cart_key']) {
      $model_cart = D('cart');
      $map_cart['cart_key'] = $_GET['cart_key'];
      if ($model_cart->where($map_cart)->find()) {
        cookie('cart_key', $_GET['cart_key']);
      } else {
        $data['cart_key'] = 'cart_'.getHashKey();
        $model_cart->add($data);
        cookie('cart_key', $data['cart_key']);
      }
      return $_GET['cart_key'];
    }

    if (cookie('cart_key')) {
        return cookie('cart_key');
    } else {
        $model_cart = D('cart');
        $data['cart_key'] = 'cart_'.getHashKey();
        $model_cart->add($data);
        $info_cart = $model_cart->where($data)->find();
        if ($info_cart){
            cookie('cart_key', $info_cart['cart_key']);
            return $data['cart_key'];
        } else {
            var_dump('car_key created failed');
        }
    }
  }
  public function user(){
    var_dump($_SESSION);
    var_dump($_GET);
    /* grab the current user's cart
    if ($_GET['username'] != $_SESSION['user']['username']) {
      $this->redirect('/cart/user/'
        .$_SESSION['user']['username']
        ."/"
        .$_GET['cart_key']);
    }
    */
  }
  public function detail(){
    //var_dump($_GET);
    $map['cart_key'] = array('neq', $_GET['cart_key']);
    $map['goods'] = array('neq', '');
    $this->get_cart_list(4, $map);
    $this->index();
  }
  public function cart_list(){
    $this->get_cart_list();
    $this->display();
  }
  public function get_cart_list($limit = 100, $map = array()){
    $model_cart = D('cart');
    $list_cart = $model_cart
      ->order('cart_id desc')
      ->where($map)
      ->limit($limit)
      ->select();
    $output['list_cart'] = $list_cart;
    $this->output = $output;
  }
}
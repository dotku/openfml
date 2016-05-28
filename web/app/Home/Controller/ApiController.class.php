<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller {

  public function username(){
    $model_user = D('user');
    $list_user = $model_user->field('username')->select();
    switch(strtolower($_SERVER['REQUEST_METHOD'])) {
        case 'put':
            $put_vars = json_decode(file_get_contents("php://input"), true);
            if (!$model_user->where($put_vars)->find()) {
                $_SESSION['user']['username'] = trim($put_vars['username']);
                $output = array(
                    'msg' => '成功更新',
                    'code' => 1
                );
            } else {
                $output = array(
                    'msg' => '更新失败，用户名已存在，请再试试别的用户名',
                    'code' => -1
                );
            }
            echo json_encode($output);
            break;
        default:
            echo json_encode($list_user);
    }
  }

  public function cart(){
    $model_cart = $model = D('cart');
    $model_goods = D('goods');
    $map['cart_key'] = getCartKey();
    // var_dump(cookie('cart_key'));
    $info_cart = $info = $model->where($map)->find();
    $output['value'] = unserialize($info['goods']);

    if ($output['value']) {
        $output['msg'] = 'get the goods successfully.';
        $output['code'] = 0;
    } else {
        $output['msg'] = 'either nothing in the cart or retrieve goods failed';
        $output['code'] = -1;
    }
    $output['request_method'] = strtolower($_SERVER['REQUEST_METHOD']);

    // multiple request method could be applied
    if (!empty($_GET)){
        // var_dump($_GET);
        $map_goods['goods_id'] = $_GET['goods_id'];
        $info_goods = $model_goods->where($map_goods)->find();
        if ($info_goods) {
            // var_dump('$info_goods');
            $cart_goods = unserialize($info_cart['goods']);
            if (!$cart_goods) {
                $cart_goods = [];
                array_push($cart_goods,$info_goods);
            } else {
                $key = array_search($info_goods["goods_id"], array_column($cart_goods, 'goods_id'));
                if ($key >= 0){
                    $cart_goods[$key]['quantity']++;
                } else {
                    array_push($cart_goods,$info_goods);
                }
            }
            
            
            // var_dump($cart_goods);
            $info_cart['goods'] = serialize($cart_goods);
            // var_dump($info_cart['goods']);
            $model_cart->save($info_cart);
        }
    }

    switch(strtolower($_SERVER['REQUEST_METHOD'])){
        case 'put':
            $this->_cart_put();
            $output = $this->output;
            break;
        case 'post':
            $this->_cart_post();
            $output = $this->output;
            break;
        default:
            // the default would be _cart_get();
    }
    $this->_cart_get();
  }

  public function _cart_get(){
    $model = D('cart');
    $map['cart_key'] = getCartKey();
    //var_dump(cookie('cart_key'));
    $info = $model->where($map)->find();
    //var_dump($info);
    if ($info['goods']) {
        $output['value'] = unserialize($info['goods']);
    } else {
        $output['msg'] = 'empty cart';
        $output['code'] = -1;
    }
    // var_dump($output);
    $output['method'] = strtolower($_SERVER['REQUEST_METHOD']);
    $this->output = $output;
    echo json_encode($this->output);
  }

  public function _cart_post(){
    // header('Content-Type:application/json; charset=utf-8');
    $model_goods = D('goods');
    $model_cart = D('cart');
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);

    $map_goods['goods_id'] = $request['goods_id'];
    
    // var_dump($request);
    $map_cart['cart_key'] = getCartKey();

    $info_goods = $model_goods->where($map_goods)->find();
    $info_cart = $model_cart->where($map_cart)->find();
    // var_dump($info_goods);
    // var_dump('$info_cart', $info_cart);
    // var_dump($_POST['goods_id']);
    if ($info_goods) {
        $cart_goods = unserialize($info_cart['goods']);
        //var_dump($info_cart['goods']);
        //var_dump($cart_goods);
        if (!$cart_goods) {
            $cart_goods = [];
            array_push($cart_goods,$info_goods);
        } else {
            $key = array_search($map_goods['goods_id'], array_column($cart_goods, 'goods_id'));
            // var_dump($key);
            if ( $key >= 0) {
                $cart_goods[$key]['quantity']++;
            } else {
                array_push($cart_goods, $info_goods);
            }
        }

        $info_cart['goods'] = serialize($cart_goods);
        $model_cart->save($info_cart);

    } else {
        $this->output['msg'] = 'item is not found';
        $this->output['code'] = -1;
    }
  }

  public function _cart_put(){
    $this->output = $putdata = fopen("php://input", "r");
    var_dump($putdata);
  }

  public function openExchangeRates(){
    $model = D('reference');
    $map['name'] = 'OpenExchangeRates';
    $info = $model->where($map)->find();
    echo $info['value'];
  }
  /**
  * 腾讯地图数据，每 1 个月更新一次
  */
  public function qqmap_ws_district(){
    $url  = 'http://apis.map.qq.com/ws/district/v1/list?key=AGLBZ-MBBRP-D2FDZ-LGW3P-SR6MK-FBB24';

    if ($_GET['id']){
        $url = 'http://apis.map.qq.com/ws/district/v1/getchildren?key=AGLBZ-MBBRP-D2FDZ-LGW3P-SR6MK-FBB24&'.http_build_query($_GET);
    }
    $geo_key = md5($url);
    if (!S('geo_'.$geo_key)){
        $data = file_get_contents($url);
        S('geo_'.$geo_key, $data, 3600*24*30);
        echo($data);
    } else {
        echo S('geo_'.$geo_key);
    }
    //var_dump($url);
    
  }

}
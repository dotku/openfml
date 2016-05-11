<?php
namespace Home\Controller;
use Think\Controller;
class VendorController extends Controller {
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
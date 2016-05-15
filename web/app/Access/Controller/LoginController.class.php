<?php
namespace Access\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    if ($_POST) {
      $model_user = D('user');
      $map['username'] = $_POST['username'];
      $info_user = $model_user->where($map)->find();
      $encryptedPassword = md5(md5($_POST['password']).$info_user['salt']);
      if ($info_user && $info_user['password'] == $encryptedPassword) {
        unset($info_user['password']);
        unset($info_user['salt']);
        $_SESSION['user'] = $info_user;
        $this->redirect('/Profile');
      } else {
        //var_dump($info_user);
        //echo md5(md5($_POST['password']).$info_user['salt']);
        $this->error('用户名或密码错误');
      }
    }
    $this->display();
  }
}
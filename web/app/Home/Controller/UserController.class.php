<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
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
    $this->redirect(U('/Home/index'));
  }

  public function login(){
    if ($_POST) {
      $model_user = D('user');
      $map['username'] = $_POST['username'];
      $info_user = $model_user->where($map)->find();
      $encryptedPassword = md5(md5($_POST['password']).$info_user['salt']);
      if ($info_user && $info_user['password'] == $encryptedPassword) {
        unset($info_user['password']);
        unset($info_user['salt']);
        $_SESSION['user'] = $info_user;
        $this->redirect('/Home');
      } else {
        //var_dump($info_user);
        //echo md5(md5($_POST['password']).$info_user['salt']);
        $this->error('用户名或密码错误');
      }
    }
    $this->display();
  }
  public function profile(){
    if(!$_SESSION['user']){
      $this->redirect(U('/Home/User/login'));
    } else {
      $this->redirect('/Home/Index/order');
    }
  }
  public function signin(){
    $this->redirect('/Home/User/login');
  }
}
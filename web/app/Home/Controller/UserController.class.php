<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
  public function index(){
    var_dump(I('path.2'));
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
    $this->redirect('/index');
  }

  public function login(){
    // var_dump($_SESSION['user']);
    if ($_POST) {
      $model_user = D('user');
      $map['username'] = $_POST['username'];
      $info_user = $model_user->where($map)->find();
      $encryptedPassword = md5(md5($_POST['password']).$info_user['salt']);
      if ($info_user && $info_user['password'] == $encryptedPassword) {
        unset($info_user['password']);
        unset($info_user['salt']);
        $_SESSION['user'] = $info_user;
        $this->redirect('/Index');
      } else {
        //var_dump($info_user);
        //echo md5(md5($_POST['password']).$info_user['salt']);
        $this->error('用户名或密码错误');
      }
    }
    if ($_SESSION['user']) {
      $this->redirect('/User/profile');
    }
    $this->display();
  }
  public function profile(){
    $this->checkLogin();
    $this->display();
  }
  public function signin(){
    $this->redirect('/Home/User/login');
  }
  public function checkLogin(){
    if(!$_SESSION['user']){ $this->redirect('/user/login');}
  }
}
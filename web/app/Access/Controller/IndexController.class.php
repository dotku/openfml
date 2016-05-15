<?php
namespace Access\Controller;
use Think\Controller;
class IndexController extends Controller {
  public function order(){
    if (!$_SESSION['user']) {
      $this->redirect('sign_in');
    }
  }
}
<?php
namespace Access\Controller;
use Think\Controller;
class LogoutController extends Controller {
    public function index(){
        session(null);
        $this->redirect('/Home');
    }
}
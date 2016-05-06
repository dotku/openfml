<?php
namespace Api\Controller;
use Think\Controller;
class UserAccessController extends Controller {
    public function index(){
        echo 'welcome to useraccess!';
    }
    public function register(){
        R('User/index');
    }
    public function login(){
        session_destroy();
        session_unset($_SESSION['password']);
    }
}
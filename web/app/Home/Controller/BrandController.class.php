<?php
namespace Home\Controller;
use Think\Controller;
class BrandController extends Controller {
    public function index(){
        if($_GET['brandname']){
            $this->display('detail');
        } else {
            $this->display('index');
        }
    }
}
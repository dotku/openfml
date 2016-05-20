<?php
namespace Api2\Controller;
use Think\Controller;
class InvoiceController extends Controller {
    public function add(){
        $model_invoice = D('invoice');
        $model_goods = D('goods');

        $inputData = json_decode($_REQUEST['input']);

        if (!$_SESSION['user']) {
            $inputData['user'] = 'guest_'.md5(time().mt_rand());
        } else {
            $inputData['user'] = $_SESSION['user'];
        }

        echo josn_encode($inputData);
    }
}
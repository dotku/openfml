<?php
namespace Api2\Controller;
use Think\Controller;
class InvoiceController extends Controller {
    public function add(){
        $model_invoice = D('invoice');
        $model_goods = D('goods');

        $inputData = json_decode($_REQUEST['input']);

        if (!$_SESSION['user']['username']) {
            $inputData['user']['username'] = 'guest_'.md5(time().mt_rand());
        }

        echo josn_encode($inputData);
    }
}
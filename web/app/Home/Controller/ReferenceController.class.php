<?php
namespace Home\Controller;
use Think\Controller;
class ReferenceController extends Controller {
  public function getOpenExchangeRates(){
    $model = D('reference');
    $map['name'] = 'OpenExchangeRates';
    return $model->where($map)->find();
  }
}
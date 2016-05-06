<?php
namespace Gear\Controller;
use Think\Controller;
class ReceiptController extends Controller {
  public function getOrderByEntryId($id){
    $model_entry = D('receipt_entry');
    $model_order = D('receipt_order');
    $map_entry['id'] = $id;
    $info_entry = $model_entry->where($map_entry)->find();

    if($info_entry) {
      $map_order['id'] = $info_entry['order_id'];
      $info_order = $model_order->where($map_order)->find();
      if ($info_order) {
        return $info_order['order_number'];
      } else {
        return 0;
      }
    } else {
      return 0;
    }
    
  }
}
<?php
namespace Home\Controller;
use Think\Controller;
class CornController extends Controller {
  public function index(){
    // var_dump('corn');
    $this->_exchangeRateUpdate();
  }
  public function _exchangeRateUpdate(){
    
    $model_reference = D('reference');
    $data['name'] = $map_reference['name'] = 'OpenExchangeRates';
    $data['update_time'] = time();
    
    // check time, update per 24 hr based
    $info_reference = $model_reference->where($map_reference)->find();

    if ($info_reference
      && ($data['update_time'] - $info_reference['update_time']) > (24 * 3600)) {

        $data['value'] = $this->_exchangeRateGetData();
        $model_reference->where($map_reference)->save($data);

    } else if (!$info_reference) {

      $data['value'] = $this->_exchangeRateGetData();
      $model_reference->add($data);
      
    }

    // var_dump(json_encode($array['rates']));
  }
  public function _exchangeRateGetData(){
    $url = 'https://openexchangerates.org/api/latest.json?app_id=51e4d4a9ba08482795344f5c5f030b9e';
    $array = getArrayByJSONURL($url);
    return json_encode($array['rates']);
  }
}
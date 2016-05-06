<?php
namespace Gear\Controller;
use Think\Controller;
class FinanceController extends Controller {
  public function getRate($currency_code = 'CNY') {
    $apiURL = 'https://openexchangerates.org/api/latest.json?app_id=51e4d4a9ba08482795344f5c5f030b9e';
    $respondData = fnmili_json_decode($apiURL);
    return $respondData['rates'][strtoupper($currency_code)];
  }
}

//https://openexchangerates.org/api/latest.json?app_id=51e4d4a9ba08482795344f5c5f030b9e
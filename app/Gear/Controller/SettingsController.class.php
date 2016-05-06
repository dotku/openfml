<?php
namespace Api\Controller;
use Think\Controller;
class SettingsController extends Controller {
    public function index(){
    }
    public function get_languages(){
        $model = D('settings_languages');
        //var_dump($model->select());
        echo json_encode($model->select());
    }
    public function set_language(){
        $_COOKIE['hl'] = $_REQUEST['hl'];
        //var_dump($_COOKIE);
        if ($_SESSION['user']) {
            // read settings
            $model = D('user');
            $map['id'] = $_SESSION['user']['id'];
            $row = $model->where($map)->find();
            
            // set options
            $options = unserialize($row['options']);
            $options['hl'] = $_REQUEST['hl'];
            
            // save options
            $row['options'] = $options;
            $model->save($row);
        }
    }
}
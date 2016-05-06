<?php
namespace Api\Controller;
use Think\Controller;
class KeyController extends Controller {
    public function index(){
    }
    public function gen_token(){
        $model = D('token');
        $input = $_REQUEST;
        $map['rid'] = $input['rid'];
        $map['usage'] = $input['usage'];
        $row = $model->where($map)->find();
        if (is_array($row)) {
            $output['msg'] = 'token already generated, regenerate a new token';
            $input['id'] = $row['id'];
            $input['code'] = md5(time());
            $input['status'] = 0;
            var_dump($input);
            $model->save($input);
        } else if ($map['rid'] && $map['usage']){
            $output['msg'] = 'token is regenerated';
            $input['code'] = md5(time());
            $input['status'] = 0;
            $model->add($input);
        } else {
            $output['msg'] = 'id or usage is not been setted';
        }
        $row = $model->where($map)->find();
        $output['data'] = $row;
        echo json_encode($output);
    }
}
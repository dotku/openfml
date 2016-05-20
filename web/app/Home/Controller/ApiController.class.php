<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends Controller {
  public function username(){
    $model_user = D('user');
    $list_user = $model_user->field('username')->select();
    switch(strtolower($_SERVER['REQUEST_METHOD'])) {
        case 'put':
            $put_vars = json_decode(file_get_contents("php://input"), true);
            if (!$model_user->where($put_vars)->find()) {
                $_SESSION['user']['username'] = trim($put_vars['username']);
                $output = array(
                    'msg' => '成功更新',
                    'code' => 1
                );
            } else {
                $output = array(
                    'msg' => '更新失败，用户名已存在，请再试试别的用户名',
                    'code' => -1
                );
            }
            echo json_encode($output);
            break;
        default:
            echo json_encode($list_user);
    }
  }

}
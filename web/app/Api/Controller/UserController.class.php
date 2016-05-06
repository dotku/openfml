<?php
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller {
    public function _initialize(){
        $this->model = D('user');
        $model = D('user');
    }
    /*
    * $item 
    * $options
    */
    public function index(){
        $this->item = I('path.1');
        //var_dump($item);
        
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->_post();
                break;
            case 'PUT':
                break;
            case 'PUT':
                break;
            default:
                $this->_get();
                break;
        }
    }
    private function _get() {
        $model = D('user');
        $filter = $_GET['filter'];
        $first_return = $_GET['first_return'];
        
        if ($this->item) {
            // filter setting
            if ($filter) {
                $map[$filter] = $this->item;
            } else {
                $map['id|username|email'] = $this->item;
            }
            // retrive data
            if ($first_return) {
                $output['data'] = $model->where($map)->find();
            } else {
                $output['data'] = $model->where($map)->select();
            }
            // output report
            if (is_array($output['data']) && !empty($output['data'])) {
                $output['msg'] = 'found the specified item';
                $output['code'] = 1;
            } else {
                $output['msg'] = 'The specified item is not exits';
                $output['code'] = -1;
            }
        } else {
            $output['data'] = $model->select();
            $output['msg'] = 'list first 1000 users';
            $output['code'] = 1;
        }
        
        // remove password
        if (is_array($output['data']) && !empty($output['data'])) {
            foreach ($output['data'] as $key =>$val) {
                unset($output['data'][$key]['password']);
            }
        } else {
            unset($output['data']['password']);
        }
        
        echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    // register 
    public function _post(){
        $model = D('user');
        $input = $_REQUEST;
        $output = array();
        $output['code'] = 0;
        // checking input
        if (!$input['username'] || !$input['password1']) {
            $output['data']['input'] = $input;
            $output['msg'] = 'password or username is missing';
            $output['code'] = -1;
            echo json_encode($output);
            return -1;
            die();
        }
        // checking if username contains alpha
        if (!ctype_alnum($input['username'])) {
            $output['msg'] = 'username must contains alpha or num only';
            $output['code'] = -4;
            echo json_encode($output);
            return -4;
            die();
        }
        // check if username exits
        $map['username'] = $input['username'];
        $row = $model->where($map)->find();
        if ($row['username'] == $map['username']) {
            $output['data'] = $row['username'];
            $output['msg'] = 'username exists';
            $output['code'] = -2;
            //var_dump($map);
            //var_dump($model->where($map)->find());
            echo json_encode($output);
            return -2;
            die();
        }
        // verify password match
        if ($input['password1'] == $input['password2']) {
            if ($output['code'] >= 0) {
                $input['password'] = md5($input['password1']);
                $model->add($input);
            } else {
                echo json_encode($output);
            }
            //var_dump();
        } else {
            $output['msg'] = 'two passwords must matched!';
            $output['code'] = -3;
            echo json_encode($output);
            return -3;
            die();
        }
        
        // login
        $map['username'] = $input['username'];
        $map['password'] = md5($input['password1']);
        
        $selection = $model->where($map)->select();
        
        if ($selection && !empty($selection) && count($selection) == 1) {
            $output['msg'] = 'register successfully';
            $output['data'] = $_SESSION['user'];
            $output['code'] = 1;
        } else {
            $output['msg'] = 'register failed in unkown';
            $output['data'] = $model->where($map)->find();
            $output['code'] = -99;
        }
        
        echo json_encode($output);
        //var_dump($_SESSION['user']);
        //var_dump($map['username']);
    }
    public function set_nickname(){
        $output = array();
        $input['nickname'] = $_REQUEST['nickname'];
        
        if ($_SESSION['user']) {
            $input['id'] = intval($_SESSION['user']['id']);
            //$row = $this->model->where($input)->find();
            //var_dump($row);
            //var_dump($input);
            $this->model->save($input);
            $_SESSION['user'] = $this->model->where($input)->find();
            unset($_SESSION['user']['password']);
            $output['msg'] = 'nickname updated successfully';
            $output['code'] = 1;
            $output['entry'] = $input;
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        } else {
            $output['msg'] = 'you need login first';
            $output['code'] = -1;
            return -1;
        }
    }
    public function set_password(){
        $output = array();
        $input['password'] = md5($_REQUEST['password']);
        
        if ($_SESSION['user']) {
            $input['id'] = intval($_SESSION['user']['id']);
            $this->model->save($input);
            $_SESSION['user'] = $this->model->where($input)->find();
            unset($_SESSION['user']['password']);
            $output['msg'] = 'password updated successfully';
            $output['code'] = 1;
            $output['entry'] = $input;
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        } else {
            $output['msg'] = 'you need login first';
            $output['code'] = -1;
            return -1;
        }
    }
    public function logout(){
        if (session_unset($_SESSION['user'])) {
            $output['msg'] = 'You logout successfully';
            $ouptut['code'] = 1;
        } else {
            $output['msg'] = 'You logout failed';
            $ouptut['code'] = -1;
        }
        $ouput['data'] = $_SESSION['user'];
        var_dump($_SESSION);
        echo json_decode($ouput);
    }
    public function login(){
        //$input = $_POST;
        $input = $_REQUEST;
        $map['id'] = $input['id'];
        $map['password'] = md5($input['password']);
        $row = $this->model->where($map)->find($map);
        if (!is_array($row)) {
            $output['msg'] = 'user can\'t be found';
        }
        var_dump('row', $row);
        echo json_encode($output);
    }
    public function password_reset(){
        $model = D('token');
        $model_user = D('user');
        $input['usage'] = 'user_password';
        $input['token'] = $_REQUEST['token'];
        $row = $model->where($input)->find();
        if ($row) {
            // update token, make it disable
            $row['status'] = 1;
            $model->save($row);
            
            $input['password'] = $_REQUEST['password'];
        }
    }
}
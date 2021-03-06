<?php 
function rest_getRequestVars(){

    $content = file_get_contents('php://input');
    return json_decode($content, true);
}
function in_array_multi($needle, $haystack){
    // var_dump($haystack);
    if (is_string($needle)){
        $needle = trim($needle);
    }
    if (is_array($haystack) && is_array($needle)){
        
        try {
            if (!array_diff($haystack, $needle)){
                return True;
            }
        } catch (\Exception $e){
            var_dump('Exception', $e);
        }

    }
    if(!is_array($haystack))
        return False;

    foreach($haystack as $key=>$value){
        if(is_array($value)){
            if(in_array_multi($needle, $value))
                return True;
            else
               in_array_multi($needle, $value);
        } else if(is_string($needle) && trim($value) === trim($needle)){//visibility fix//
            var_dump('string check');
            error_log("$value === $needle setting visibility to 1 hidden");
            return True;
        }
    }

    return False;
}
function getArrayByJSONURL($url){
    $json = file_get_contents($url);
    return json_decode($json, true);
}

/**
 * getCartKey
 * 此函数将废弃使用
 */

function getCartKey(){
    if (cookie('cart_key')) {
        return cookie('cart_key');
    } else {
        $model_cart = D('cart');
        $data['cart_key'] = 'cart_'.getHashKey();
        $model_cart->add($data);
        $info_cart = $model_cart->where($data)->find();
        if ($info_cart){
            cookie('cart_key', $info_cart['cart_key']);
            return $data['cart_key'];
        } else {
            var_dump('car_key created failed');
        }
    }
}
function getHashKey(){
    return md5(time().mt_rand());
}
function getUsername(){
    if ($_SESSION['user']['username']) {
        return $_SESSION['user']['username'];
    } else {
        $_SESION['user']['username'] = 'guest_'.md5(time().mt_rand);
        return $_SESION['user']['username'];
    }
}

function getUserid(){
    if ($_SESSION['user']['userid']) {
        return $_SESSION['user']['userid'];
    } else {
        return 0;
    }
}

function fnmili_json_decode($requestURL, $data) {
    if ($data) {
        $requestURL = $requestURL . '?' . http_build_query($data);
    }
    return json_decode(file_get_contents($requestURL), true);

}
function is_mobile() {
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
        return true;
    } else {
        return false;
    }
 }
function is_weixin() {
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }
        return false;
}
function dk_json_encode($arr) {
    return json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}
function dk_json_decode($requestURL, $data) {
    if ($data) {
        $requestURL = $requestURL . '?' . http_build_query($data);
    }
    return json_decode(file_get_contents($requestURL), true);
}
function upload_img($relation, $description = '',$readperm = 0){
    $upload = new \Think\Upload(C('upload_config'));// 实例化上传类
    $model_attachment = D('attachment');
    //$info_attachment = $model_attachment->order('aid desc')->find();
    //var_dump($info_attachment);
    $info = $upload->upload();
    if (!$info){
        var_dump($upload->getError());
    } else {
        //var_dump($info);
        foreach($info as $key => $val) {
            $val['dateline'] = time();
            $val['filename'] = $val['name'];
            $val['filesize'] = $val['size'];
            $val['attachment'] = $val['savepath'] . $val['savename'];
            $val['description'] = $description;
            $val['readperm'] = $readperm;
            $val['isimage'] = 1;
            $val[$relation['field_name']] = $relation['field_value'];
            //var_dump($val);
            try {
                $model_attachment->data($val)->add();
                // var_dump('result', $model_attachment->data($val)->add());
            } catch (\Exception $e) {
                var_dump($e);
            }
        }
    }
}
<?php
namespace Home\Controller;
use Think\Controller;
use Org\Tencentyun\Image;
use Vendor\Tencentyun\Auth;
use Vendor\Tencentyun\Video;
class IndexController extends Controller {
    public function index(){
		$model_request = D('request');
		$this->list_request = $model_request->order('request_id desc')->limit(8)->select();
		if ($_POST) {
			/*
			if ($_FILES["file"]["error"] > 0)
			  {
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			if (move_uploaded_file($_FILES['request_image']['tmp_name'], RUNTIME_PATH)) {
				echo "File is valid, and was successfully uploaded.\n";
			} else {
				echo "Possible file upload attack!\n";
			}
			var_dump($_FILES["request_image"]);
			$uploadRet = Image::upload($_FILES['request_image']['tmp_name']);
			if (0 === $uploadRet['code']) {
    $fileid = $uploadRet['data']['fileid'];

    // 查询管理信息
    $statRet = Image::stat($fileid);
    var_dump($statRet);

    // 复制
    $copyRet = Image::copy($fileid);
    var_dump($copyRet);

    // 生成私密下载url
    $downloadUrl = $copyRet['data']['downloadUrl'];
    $sign = Auth::appSign($downloadUrl, 0);
    $signedUrl = $downloadUrl . '?sign=' . $sign;
    var_dump($signedUrl);

    //生成新的上传签名
    $expired = time() + 999;
    $sign = Auth::appSign('http://web.image.myqcloud.com/photos/v1/200679/0/', $expired);
    var_dump($sign);

    $delRet = Image::del($fileid);
    var_dump($delRet);
} else {
    var_dump($uploadRet);
}
			*/
			if ($model_request->add($_POST)) {
				$this->success('请求以发送成功，请等待回复');
			} else {
				$this->erorr('请求失败');
			}
		} else {
			$this->display();
		}
    }
}
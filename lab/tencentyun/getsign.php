<?php

require 'include.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = 'upload';
}

//以下bucket，projectId信息请到http://console.qcloud.com/image/bucket获取,并替换为自己的项目信息
$bucket = 'fnmili';     // 空间名称
$projectId = '10007299';  // 项目ID
$userid = 0;              // 用户ID 可以自定义 默认为0

switch ($type) {
    case 'upload':
        $fileid = '/u/can/use/slash/sample'.time();                              // 自定义文件名
        //生成新的上传签名
        $url = Tencentyun\ImageV2::generateResUrl($bucket, $userid, $fileid);
        $expired = time() + 999;
        $sign = Tencentyun\Auth::getAppSignV2($bucket, $fileid, $expired);
        $ret = array('url' => $url,'sign' => $sign);
        exit(json_encode($ret));
    case 'stat':
        $fileid = rawurldecode($_GET['fileid']);
        $url = Tencentyun\ImageV2::generateResUrl($bucket, $userid, $fileid);
        $ret = array('url' => $url);
        exit(json_encode($ret));
    case 'del':
    case 'copy':
        $fileid = rawurldecode($_GET['fileid']);
        $url = Tencentyun\ImageV2::generateResUrl($bucket, $userid, $fileid, $type);
        $sign = Tencentyun\Auth::getAppSignV2($bucket, $fileid, 0);
        $ret = array('url' => $url,'sign' => $sign);
        exit(json_encode($ret));
    case 'download':
        $fileid = rawurldecode($_GET['fileid']);
        $expired = time() + 999;
        $sign = Tencentyun\Auth::getAppSignV2($bucket, $fileid, $expired);
        $ret = array('sign' => $sign);
        exit(json_encode($ret));
    default:
        exit;
}

//end of script
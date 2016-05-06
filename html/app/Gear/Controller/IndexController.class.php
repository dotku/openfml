<?php
namespace Api\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo 'hello, api!';
    }
    public function media_ajax(){
        $keywords = '%E6%97%A7%E9%87%91%E5%B1%B1';
        //$userip = $_SERVER['REMOTE_ADDR'];
        $userip = '120.198.231.24';
        if (isset($_GET['keywords'])) {
            $keywords = urldecode($_GET['keywords']);
            $keywords = urlencode($keywords);
        }
       
        $url_video = 'https://ajax.googleapis.com/ajax/services/search/video?v=1.0&rsz=8&start=56&scoring=d&category=news&q=' . $keywords;
        $url_news = 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&rsz=8' .'&userip='. $userip .'&q=' . $keywords;
        $data_video = json_decode(file_get_contents($url_video), true);
        $data_news = json_decode(file_get_contents($url_news), true);
        
        var_dump( $data_video['responseData'] );
    }
}
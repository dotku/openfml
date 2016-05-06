<?php 
    /*
    * config_local.php                用于设置代码所在的环境
    * define()                             一般都是固定的设置，必须在 ThinkPHP 运行前设置好
    * $config['lib_thinkphp']       ThinkPHP 的核心文件
    */
    require_once 'config_local.php';
    require_once 'define_common.php';
    
    define('BIND_MODULE','Api');
    
    require_once $config_local['lib_thinkphp'];
    C('URL_CASE_INSENSITIVE', true);
    //var_dump(C('URL_CASE_INSENSITIVE'));
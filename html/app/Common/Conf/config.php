<?php
require dirname(dirname(dirname(dirname(__FILE__)))).'/config_local.php';
define('__PUB__', __ROOT__.'/public');
/**
 * 默认配置信息
 * [!]URL_CASE_INSENSITIVE 会被调试模式影响到
 */
$config_default = array(
    // API Keys
    'MACY_API'                => 'nhz2kxnfgtd9g7p4h2j9nj6q', // 5000 call perday
    // ThinkPHP
    'TMPL_ENGINE_TYPE'        => 'PHP',
    'TMPL_TEMPLATE_SUFFIX'    => '.html',
    // 'MODULE_ALLOW_LIST' => array('Home','User'),
    // 'DEFAULT_MODULE'    => 'Home',
    'URL_CASE_INSENSITIVE'    => true, 
    'URL_HTML_SUFFIX'         =>'',

    // MySQL database
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'thinkphp_fnmili', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'admin123', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_CHARSET'=> 'utf8', // 字符集

);
return array_merge($config_default, $config_local);
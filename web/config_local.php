<?php

/*
* 由于服务器环境，开发环境，各有不同，本文件用于本地环境的配置搭建；
* 本文件将会被 /index.php 和 /Common/Conf/config.php 文件同时引用
*/
$config_local = array(
    // SITE
    'site_title' => '范米粒',
    'site_subtitle' => '一个基于 ThinkPHP 的开源免费电商系统',
    // library
    'lib_thinkphp' => '../framework/thinkphp/3.2.3/ThinkPHP.php',
    /*
    hostname: 10.9.1.188
    jdbcUrl: jdbc:mysql://10.9.1.188:3306/cf_3a0c73e9_e71c_46eb_8dce_b09350405800?user=zyMN5R9FebiJKxWS&password=JHyknPfY0Q8FmBKs
    name: cf_3a0c73e9_e71c_46eb_8dce_b09350405800
    password: JHyknPfY0Q8FmBKs
    port: 3306
    uri: mysql://zyMN5R9FebiJKxWS:JHyknPfY0Q8FmBKs@10.9.1.188:3306/cf_3a0c73e9_e71c_46eb_8dce_b09350405800?reconnect=true
    username: zyMN5R9FebiJKxWS
    */
     // database

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '138.68.195.77', // 服务器地址
    'DB_NAME'   => 'tp_fnmili', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'do@dmin123', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_CHARSET'=> 'utf8', // 字符集

    // router
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' =>array(
        'api2/:table' => array('Api2/Index/index'),
        'home/brand/:brandname' => array('Brand/index'),
        //''
    ),
);
<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 16:55
 */

//  配置文件
return [

    #数据库配置
    'host'                  => '127.0.0.1',      //连接地址
    'user'                  => 'root',           //用户名
    'pswd'                  => 'admin',          //密码
    'dbnm'                  => 'ask',            //库名
    'port'                  => 3306,             //端口
    'char'                  => 'utf8',           //字符集编码
    'table_prefix'          => 'ask_',           //表前缀


    #Smarty模板配置
    'smarty' => [
        'setLeftDelimiter'  => '{{',             //左定界标识符
        'setRightDelimiter' => '}}',             //右定界标识符
        'setTemplateDir'    => 'view',           //设置application下的模板目录
        'setCompileDir'     => 'runtime'         //设置根目录下的缓存临时文件目录
    ],

    #0表示开启session
    'session_start'         => '0',

    #默认时区设置
    'date_default_timezone' => 'PRC',

    #伪静态后缀
    'postfix' => 'html',
];
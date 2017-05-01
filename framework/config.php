<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 20:05
 */

//  配置文件
return [

    #数据库配置
    'host' => '127.0.0.1',      //连接地址
    'user' => 'root',           //用户名
    'pswd' => 'admin',          //密码
    'dbnm' => 'ask',            //库名
    'port' => 3306,             //端口
    'char' => 'utf8',           //字符集编码
    'table_prefix' => 'ask_',   //表前缀

    #Smarty模板配置
    'smarty' => [
        'setLeftDelimiter' => '<{',        //左定界标识符
        'setRightDelimiter' => '}>',       //右定界标识符
        'setTemplateDir' => 'view',        //设置application下的模板目录
        'setCompileDir' => 'runtime'       //设置根目录下的缓存临时文件目录
    ],

    #URL参数配置  ?m=admin&c=index&a=index    (不建议上线后修改)
    'argument_app' => 'm',          //application参数目录
    'argument_controller' => 'c',   //controller参数文件
    'argument_action' => 'a',        //action方法

    'default_app' => 'home',            //默认进入application的home目录
    'default_controller' => 'index',    //默认IndexController控制器
    'default_action' => 'index',        //默认Index方法

    #伪静态后缀
    'postfix' => 'html',
];
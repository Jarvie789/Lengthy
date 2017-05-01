<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 19:30
 */

//  目录配置常量

    #根目录
    define('__ROOT__',str_replace('\\','/',realpath(dirname(__FILE__).'/../')));
    #项目目录
    define('__APP__',__ROOT__.'/application');
    #框架核心目录
    define('__FRAME__',__ROOT__.'/framework');
    #框架核心第三方文件目录
    define('__VENDOR__',__FRAME__.'/vendor');

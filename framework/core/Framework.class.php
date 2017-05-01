<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:14
 */

namespace framework\core;

class Framework
{
    public function __construct()
    {
        $this->autoLoad();  //自动加载
        $this->configs();   //配置文件
        $this->initUrl();   //初始化、美化URL
        $this->initPath();  //实例化参数
    }
/*
 * 引入常量配置文件
 * 注册自动加载函数方法
 */
    private function autoLoad()
    {
        require_once "../framework/common.php";
        require_once "../application/common.php";
        spl_autoload_register(array($this,"autoLoader"));
    }
/*
 * 自动加载类方法
 */
    private function autoLoader($classname)
    {
        if ($classname  == 'Smarty'){
            require_once __VENDOR__.'/smarty/Smarty.class.php';
            return;
        }
        $classname_arr = explode('\\',$classname);
        if ($classname_arr[0] == 'framework'){
            $basic_name = __ROOT__;
        }else{
            $basic_name = __APP__;
        }
        $sub_path = str_replace('\\','/',$classname);
        $class_file = $basic_name.'/'.$sub_path.'.class.php';
        if (file_exists($class_file)){
            require_once $class_file;
        }
    }
/*
 * 加载框架下的配置文件
 */
    private function loadFrameworkConfig()
    {
        $config_file = __FRAME__.'/config.php';
        if (file_exists($config_file)){
            return require_once $config_file;
        }else{
            return array();
        }
    }
/*
 * 加载项目中的配置文件
 */
    private function loadAppConfig()
    {
        $config_file = __APP__.'/config.php';
        if (file_exists($config_file)){
            return require_once $config_file;
        }else{
            return array();
        }
    }
/*
 * 合并配置文件并设置为超全局变量
 */
    private function configs()
    {
        $config_one = $this->loadFrameworkConfig(); //框架核心中的config.php
        $config_two = $this->loadAppConfig();       //项目application中的config.php

        $GLOBALS['config'] = array_merge($config_one,$config_two);  //以第二个配置文件为准进行合并
    }
/*
 * 初始URL、使用PATH_INFO美化
 */
    private function initUrl()
    {
        if (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])){
            $path_info = rtrim($_SERVER['PATH_INFO'],'/');
            $path_info = str_replace(stristr($path_info,'.'),'',$path_info);
            $path_url = explode('/',$path_info);
            $path_url = array_slice($path_url,1);

            $url_length = count($path_url);
            if ($url_length >= 3){
                define('APP',$path_url[0]);
                define('CONTROLLER',$path_url[1]);
                define('ACTION',$path_url[2]);
                if ($url_length > 3){
                    $param = array_slice($path_url,3);
                    for ($i = 0;$i < count($param);$i += 2){
                        $_GET[$param[$i]] = $param[$i+1];
                    }
                }
            }elseif ($url_length == 2){
                define('APP',$path_url[0]);
                define('CONTROLLER',$path_url[1]);
                $action = isset($_GET[$GLOBALS['config']['argument_action']]) ? $_GET[$GLOBALS['config']['argument_action']] : $GLOBALS['config']['default_action'];
                define('ACTION',$action);
            }elseif ($url_length == 1){
                define('APP',$path_url[0]);
                $controller =  isset($_GET[$GLOBALS['config']['argument_controller']]) ? $_GET[$GLOBALS['config']['argument_controller']] : $GLOBALS['config']['default_controller'];
                define('CONTROLLER',$controller);
                $action = isset($_GET[$GLOBALS['config']['argument_action']]) ? $_GET[$GLOBALS['config']['argument_action']] : $GLOBALS['config']['default_action'];
                define('ACTION',$action);
            }
        }else{
            $this->initMva();
        }
    }
/*
 * 接收URL传来的参数方法
 */
    private function initMva()
    {
        $app = isset($_GET[$GLOBALS['config']['argument_app']]) ? $_GET[$GLOBALS['config']['argument_app']] : $GLOBALS['config']['default_app'];
        define('APP',$app);
        $controller =  isset($_GET[$GLOBALS['config']['argument_controller']]) ? $_GET[$GLOBALS['config']['argument_controller']] : $GLOBALS['config']['default_controller'];
        define('CONTROLLER',$controller);
        $action = isset($_GET[$GLOBALS['config']['argument_action']]) ? $_GET[$GLOBALS['config']['argument_action']] : $GLOBALS['config']['default_action'];
        define('ACTION',$action);
    }
/*
 * 通过namespace实例化URL传来的参数类
 * 并调用方法
 */
    private function initPath()
    {
        $controller_name = APP.'\controller\\'.CONTROLLER.'Controller';
        $controller = new $controller_name();
        $action = ACTION;
        $controller->$action();
    }
}
?>
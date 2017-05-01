<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/5/1
 * Time: 21:38
 */
/*
 * U方法实现url跳转。
 */
function smarty_function_U($url)
{
    $root = $_SERVER['SCRIPT_NAME'];
    $root_url = str_replace('index.php', '', $root);
    $root = $root_url . $url['url'] . '.' . $GLOBALS['config']['postfix'];

    if (isset($url['get']) && !empty($url['get'])) {
        $root = $root_url . $url['url'];
        foreach ($url['get'] as $k => $v) {
            $root .= '/' . $k . '/' . $v;
        }
        $root .= '.' . $GLOBALS['config']['postfix'];
    }
    return $root;
}
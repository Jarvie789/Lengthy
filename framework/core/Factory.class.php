<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:17
 */

namespace framework\core;
/*
 * 工厂类：根据传递的模型类，返回单例的数据
 */
class Factory
{
    /*
     * 操作模型方法
     */
    public static function M($modelName)
    {
        if (substr($modelName,-5) != 'Model'){
            $modelName .= 'Model';
        }
        if (!strstr($modelName,'\\')){
            $modelName = APP.'\model\\'.$modelName;
        }
        static $model_list = array();
        if (!isset($model_list[$modelName])){
            $model_list[$modelName] = new $modelName();
        }
        return $model_list[$modelName];
    }
}
?>
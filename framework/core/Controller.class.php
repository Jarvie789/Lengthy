<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:15
 */

namespace framework\core;


class Controller
{
    protected $smarty;

    public function __construct()
    {
        $this->initSession();
        $this->initDefaultTime();
        $this->initSmarty();
    }
    /*
     * Session设置
     */
    public function initSession()
    {
        if ($GLOBALS['config']['session_start'] == 0){
            session_start();
        }
    }
    /*
     * 默认时区设置
     */
    public function initDefaultTime()
    {
        date_default_timezone_set('PRC');
    }

    /*
     * Smarty配置
     */
    public function initSmarty()
    {
        $this->smarty = new \Smarty();

        $this->smarty->setLeftDelimiter($GLOBALS['config']['smarty']['setLeftDelimiter']);
        $this->smarty->setRightDelimiter($GLOBALS['config']['smarty']['setRightDelimiter']);

        $this->smarty->setTemplateDir(__APP__ . '/' . APP . '/' . $GLOBALS['config']['smarty']['setTemplateDir'] . '/');
        $this->smarty->setCompileDir(__ROOT__ . '/' . $GLOBALS['config']['smarty']['setCompileDir'] . '/');
    }

}

?>
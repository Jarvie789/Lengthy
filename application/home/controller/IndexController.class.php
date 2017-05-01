<?php

/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 21:31
 */
namespace home\controller;
use framework\core\Controller;
use framework\core\Factory;

class IndexController extends Controller
{
    public function index()
    {
        $Notice = 'Notice：建议配置虚拟主机到public目录下，或者你可以配置application下的common.php';
        $this->smarty->assign('notice',$Notice);

        $this->smarty->display('index.html');
    }
}

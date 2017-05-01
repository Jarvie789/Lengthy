<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:05
 */

namespace framework\tools;

use \PDO;
use \PDOException;

//@class PDO操作数据库工具类

class DAOPDO
{
    private static $instance;
    private $pdo;

    private function __construct($option)
    {
        $this->checkPDOParam($option);//检查并初始化参数
        $this->link();//初始化PDO连接数据库
    }

    public static function getSingleton(array $option)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($option);
        }
        return self::$instance;
    }

    private function checkPDOParam($option)//检查传进来的连接数据库参数
    {
        $this->host = isset($option['host']) ? $option['host'] : '';
        $this->user = isset($option['user']) ? $option['user'] : '';
        $this->pswd = isset($option['pswd']) ? $option['pswd'] : '';
        $this->dbnm = isset($option['dbnm']) ? $option['dbnm'] : '';
        $this->port = isset($option['port']) ? $option['port'] : '';
        $this->char = isset($option['char']) ? $option['char'] : '';
        if ($this->host == '' || $this->user == '' || $this->pswd == '' || $this->dbnm == '' || $this->port == '' || $this->char == '') {
            exit('传入连接数据库的参数不能有空');
        }
    }

    private function link()//连接数据库
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbnm;port=$this->port;charset=$this->char";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pswd);
        } catch (PDOException $exception) {
            exit('数据库连接出错，错误信息是：' . $exception->getMessage());
        }
    }

    public function fetchRows($sql)
    {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement) {
            return $pdo_statement->fetch();
        } else {
            $this->errorNotice($sql);
            return FALSE;
        }
    }

    public function fetchAll($sql)
    {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement) {
            return $pdo_statement->fetchAll();
        } else {
            $this->errorNotice($sql);
            return FALSE;
        }
    }

    public function exec($sql)
    {
        $num = $this->pdo->exec($sql);
        if ($num === FALSE && $num != 0){
			$this->errorNotice($sql);
            return false;
        }
		return $num;
    }

    public function fetchColumn($sql, $num = 0)
    {
        $pdo_statement = $this->pdo->query($sql);
        if ($pdo_statement) {
            return $pdo_statement->fetchColumn($num);
        } else {
            $this->errorNotice($sql);
            return FALSE;
        }
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function quote($date)
    {
        return $this->pdo->quote($date);
    }

    private function errorNotice($sql)
    {
        echo 'SQL语句执行出错，错误语句是：' . $sql . '<br>错误信息是：' . $this->pdo->errorInfo()[2];
    }

    private function __clone()
    {

    }

}
?>
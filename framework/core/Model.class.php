<?php
/**
 * Created by PhpStorm.
 * User: qiutianjia
 * Date: 2017/4/13
 * Time: 17:16
 */

namespace framework\core;
/*
 * 核心model
 */
use framework\tools\DAOPDO;

class Model
{
    protected $pdo;         //PDO
    protected $true_table;  //表名
    protected $primary_key; //主键字段

    public function __construct()
    {
        $this->initDao();
        $this->initTrueTable();
        $this->initField();
    }
/*
 * 实例化daopao类
 */
    public function initDao()
    {
        $option = $GLOBALS['config'];
        $this->pdo = DAOPDO::getSingleton($option);
    }
/*
 * 获取全称表名(+表前缀)
 */
    public function initTrueTable()
    {
        $this->true_table = '`'.$GLOBALS['config']['table_prefix'].$this->logic_table.'`';
    }
/*
 * 获取表的主键字段
 */
    public function initField()
    {
        $sql = "DESC $this->true_table";
        $result = $this->pdo->fetchAll($sql);
        foreach ($result as $k => $v){
            if ($v['Key'] == 'PRI'){
                $this->primary_key = $v['Field'];
                continue;
            }
        }
    }
/*
 * insert方法
 *          $date = array(
 *              'field' => 'value',
 *          );
 *  return lastInsertId;
 */
    public function insert($date)
    {
        $sql = "INSERT INTO $this->true_table";

        $fields = array_keys($date);
        $fields_list = array_map(function ($v){
            return '`'.$v.'`';
        },$fields);

        $fields = ' ('.implode(',',$fields_list).') ';
        $sql .= $fields;

        $fields_value = array_values($date);
        $fields_value = array_map(array($this->pdo,"quote"),$fields_value);
        $fields_value = 'VALUES ('.implode(',',$fields_value).')';
        $sql .= $fields_value;

        $this->pdo->exec($sql);
        return $this->pdo->lastInsertId();
    }
/*
 * delete方法
 * 通过主键字段删除数据
 * @para $id    主键value
 * return $pdo->exec
 */
    public function delete($id)
    {
        $sql = "DELETE FROM $this->true_table WHERE $this->primary_key = $id";
        return $this->pdo->exec($sql);
    }
/*
 * update方法
 * @para $date
 *          $date = array(
 *              'field' => 'value',
 *          );
 * @para $where  条件
 * return $pdo->exec
 */
    public function update($data,$where = null)
    {
        if (!$where){
            return false;
        }else{
            foreach ($where as $k => $v){
                $where_str = " WHERE `$k` = '$v'";
            }
        }
        $sql = "UPDATE $this->true_table SET ";
        $fields = array_keys($data);
        $fields = array_map(function ($v){
            return '`'.$v.'`';
        },$fields);

        $fields_values = array_values($data);
        $fields_values = array_map(array($this->pdo,"quote"),$fields_values);

        $str = "";
        foreach ($fields as $k => $v){
            $str .= $v.'='.$fields_values[$k].',';
        }
        $str = substr($str,0,-1);
        $sql .= $str.$where_str;
        return $this->pdo->exec($sql);
    }
/*
 * find查询方法
 * @para $date array
 *      $date = array(
 *          'field','field'
 *      )
 * @para $where 条件
 *      $where = array(
 *          'field' => 'value',
 *      );
 * return $pdo->pdo->fetchAll();
 */
    public function find($data = array(),$where = array())
    {
        if (!$data){
            $fiedls = '*';
        }else{
            $fiedls = array_map(function ($v){
                return '`'.$v.'`';
            },$data);
            $fiedls = implode(',',$fiedls);
        }
        if (!$where){
            $sql = "SELECT $fiedls FROM $this->true_table";
        }else{
            foreach ($where as $k => $v){
                $where_str = '`'.$k.'` = '."'$v'";
            }
            $sql = "SELECT $fiedls FROM $this->true_table WHERE $where_str";
        }
        return $this->pdo->fetchAll($sql);
    }
}
?>
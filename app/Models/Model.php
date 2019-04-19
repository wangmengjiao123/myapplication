<?php

/**
 * Created by PhpStorm.
 * User: wangmengjiao3
 * Date: 2019/4/19
 * Time: 14:19
 */

class Model {
    protected $connection;
    protected $_result;

    protected $_model;
    protected $_table;

    function __construct() {

        // 连接数据库
        $this->connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

        // 转换模型+Model为模型名称

        // 获取对象所属类的名称
        $this->_model = get_class($this);
        $this->_model = rtrim($this->_model, 'Model');

        // 数据库表名与类名一致
        $this->_table = strtolower($this->_model);
    }

    function __destruct() {

    }
    //连接数据库
    function connect($address, $account, $pwd, $name) {
        $this->connection = @mysqli_connect($address, $account, $pwd);
        if ($this->connection != 0) {
            if (mysqli_select_db($name, $this->connection)) {
                return 1;
            }
            else {
                return 0;
            }
        }
        else {
            return 0;
        }
    }

    //断开连接
    function disconnect() {
        if (@mysqli_close($this->connection) != 0) {
            return 1;
        }  else {
            return 0;
        }
    }

    //sql查询
    function query($query, $singleResult = 0) {

        $this->_result = mysqli_query($query, $this->connection);

        if (preg_match("/select/i",$query)) {
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
            $numOfFields = mysqil_num_fields($this->_result);
            for ($i = 0; $i < $numOfFields; ++$i) { array_push($table,mysqli_field_table($this->_result, $i));
                array_push($field,mysql_field_name($this->_result, $i));
            }

            while ($row = mysqli_fetch_row($this->_result)) {
                for ($i = 0;$i < $numOfFields; ++$i) { $table[$i] = ucfirst($table[$i]); $tempResults[$table[$i]][$field[$i]] = $row[$i]; } if ($singleResult == 1) { mysqli_free_result($this->_result);
                    return $tempResults;
                }
                array_push($result,$tempResults);
            }
            mysqli_free_result($this->_result);
            return($result);
        }

    }

    /** 获取错误信息 **/
    function getError() {
        return mysqli_error($this->connection);
    }

}
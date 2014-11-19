<?php

/**
 * @author quyetnd
 */

class MySQL {

    public static $instance = NULL;
    private $_connecter;
    protected $_result;

    /**
     * 
     * @return Mysql
     */
    public static function getInstance($options) {
        if (self::$instance[$options['dbname']] === NULL) {
            self::$instance[$options['dbname']] = new self($options);
        }
        return self::$instance[$options['dbname']];
    }

    public function __construct($options) {
        $this->connect($options);
    }

    public function __destruct() {
        $this->disconnect();
    }

    public function query($sql) {
        try {
            $result = mysql_query($sql, $this->_connecter);
            return $result;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return NULL;
    }

    public function execute_query_to_array($qr) {
        $result = $this->query($qr);
        if (!empty($result)) {
            $all = array();
            while ($row = mysql_fetch_assoc($result)) {
                $all[] = $row;
            }
            return $all;
        }
        return array();
    }

    public function insert($table, $params) {
        try {
            if (array_key_exists('rt', $params)) {
                array_shift($params);
            }
            $arrayString = array();
            $arrayKey = array_keys($params);
            if (is_array($arrayKey)) {
                foreach ($arrayKey as $value) {
                    $arrayString[] = "`$value`";
                }
            }

            $keyString = implode(', ', $arrayString);

            $arrayValueString = array();
            $arrayValue = array_values($params);
            if (is_array($arrayValue)) {
                foreach ($arrayValue as $value) {
                    $arrayValueString[] = Mysql::quote($value);
                }
            }
            $valueString = implode(', ', $arrayValueString);

            $sql = "INSERT INTO `$table` ($keyString) VALUES ($valueString)";
            mysql_query($sql, $this->_connecter);
            return mysql_insert_id($this->_connecter);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return NULL;
    }

    public function update($table, $id, $params, $idFieldName = '') {
        try {
            if (array_key_exists('rt', $params)) {
                array_shift($params);
            }
            $arrayString = array();
            if (is_array($params)) {
                foreach ($params as $key => $value) {
                    $value = Mysql::quote($value);
                    $arrayString[] = "`$key` = $value";
                }
            }
            $keyString = implode(', ', $arrayString);
            if(empty($idFieldName)){
                $sql = "UPDATE `$table` SET $keyString WHERE id=$id";
            } else {
                $sql = "UPDATE `$table` SET $keyString WHERE $idFieldName = $id";
            }
            //var_dump($sql);exit;
            return mysql_query($sql, $this->_connecter);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return NULL;
    }

    public function delete($table, $id, $idFieldName = '') {
        if(empty($idFieldName)){
            $sql = "DELETE FROM `$table` WHERE id=$id";
        } else {
            $sql = "DELETE FROM `$table` WHERE $idFieldName = $id";
        }
        try {            
            return mysql_query($sql, $this->_connecter);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return NULL;
    }

    function select_all($table) {
        $query = 'select * from `' . $table . '`';
        $result = $this->query($query);
        if (!empty($result)) {
            $all = array();
            while ($row = mysql_fetch_assoc($result)) {
                $all[] = $row;
            }
            return $all;
        }
        return array();
    }

    /** Get number of rows * */
    function getNumRows() {
        return mysql_num_rows($this->_result);
    }

    function freeResult() {
        mysql_free_result($this->_result);
    }

    protected function connect($options) {
        $this->_connecter = mysql_connect($options['host'], $options['username'], $options['password']);
        mysql_query("SET NAMES utf8"); 
        if (!$this->_connecter) {
            die('Not connected : ' . mysql_error());
        }
        $db_selected = mysql_select_db($options['dbname'], $this->_connecter);
        if (!$db_selected) {
            die('Can\'t use foo : ' . mysql_error());
        }
    }

    /** Connects to database * */
    private function disconnect() {
        if ($this->_connecter) {
            mysql_close($this->_connecter);
        }
    }

    public static function quote($value) {
        // Stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }

        // Quote if not integer
        if (!is_numeric($value)) {
            $value = "'" . mysql_real_escape_string($value) . "'";
        }

        return $value;
    }

}
<?php

/**
 * @author quyetnd
 */
class baseModel
{

    public static $instance;
    protected $_mysql;

    function __construct()
    {
        $optionConnect = array(
            'host' => DB_HOST,
            'username' => DB_USER,
            'password' => DB_PASS,
            'dbname' => DB_NAME,
        );
        $this->_mysql = Mysql::getInstance($optionConnect);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new baseModel();
        }
        return self::$instance;
    }

    public function get($name)
    {
        $file = APP_PATH . '/models/' . $name . ".php";
        if (file_exists($file)) {
            require_once($file);
            $class = str_replace("model", "", strtolower($name)) . "Model";
            return new $class;
        }
        return NULL;
    }

    function __destruct()
    {
        
    }

}

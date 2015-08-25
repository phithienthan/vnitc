<?php

/**
 * Base model singleton class
 * @author quyetnd
 */
class baseModel extends singleton
{
    protected $_mysql;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */    
    protected function __construct()
    {
        $optionConnect = array(
            'host' => DB_HOST,
            'username' => DB_USER,
            'password' => DB_PASS,
            'dbname' => DB_NAME,
        );
        $this->_mysql = Mysql::getInstance($optionConnect);
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
    
}

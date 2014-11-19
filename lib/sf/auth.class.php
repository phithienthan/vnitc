<?php

/**
 * @author quyetnd
 */
class Auth
{

    public static $instance = NULL;
    public static $_mysql;

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
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function isLogin()
    {
        if (isset($_SESSION['username']) && $_SESSION['username']) {
            return true;
        }
        return false;
    }

    public static function logout()
    {
        session_destroy();
    }

    public function checkLogin($username, $password)
    {
        $qr = 'SELECT * FROM sf_users where username = ' . $this->_mysql->quote($username);
        $admin = $this->_mysql->execute_query_to_array($qr);
        if (count($admin) == 1) {
            $admin = $admin[0];
            if (md5($password) == $admin['password']) {
                $_SESSION['username'] = $username;
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

}

<?php

/**
 * @author quyetnd
 */
/**
 * Database config
 */
define('DB_HOST', '127.0.0.1'); // IP host
define('DB_USER', 'root'); // User database
define('DB_PASS', ''); // Password database
define('DB_NAME', 'lonmuong_db'); // Database name

/**
 * Auto redirect to this url when mobile detected
 */
define('MOBILE_URL', 'http://lonmuongkhuong.com.vn/');

/**
 * Default for SEO
 */
define('DEFAULT_TITLE', 'Lon Muong Khuong dac san Lao Cai');
define('DEFAULT_DESCRIPTION', 'Lon Muong Khuong dac san Lao Cai');
define('DEFAULT_KEYWORDS', 'Lon Muong Khuong dac san Lao Cai');

/**
 * SESSION timeout
 */
define('SESSION_TIMEOUT', 21600);

/**
 * define common path
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__));
define('APP_PATH', ROOT . DS . 'app' . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('LIB_PATH', ROOT . DS . 'lib' . DS);
define('CORE_PATH', LIB_PATH . DS . 'sf' . DS);
define('FCK_PATH', LIB_PATH . DS . 'fckeditor' . DS);
define('MOBILE_DETECT_PATH', LIB_PATH . DS . 'mobile_detect' . DS);

define('SKIN_PATH', '/skin/');
define('AVATAR_PATH', '/uploads/image/avatar/');
define('AVATAR_RESIZE_PATH', '/uploads/image/avatar/resize/');

/**
 * Define mobile detect
 */
define('TABLET', 'tablet');
define('PHONE', 'phone');
define('COMPUTER', 'computer');
?>

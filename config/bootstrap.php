<?php

/**
 * @author quyetnd
 */
/**
 * include the config.php file 
 */
require __DIR__ . '/config.php';

/**
 * set session timeout
 */
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
    /**
     * last request was more than SESSION_TIMEOUT second ago
     */
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

/**
 * Ensure lib is on include_path
 */
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), CORE_PATH,)));
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), FCK_PATH,)));
set_include_path(implode(PATH_SEPARATOR, array(get_include_path(), MOBILE_DETECT_PATH,)));

/**
 * Autoloader
 */
function sf_autoloader($class)
{
    include $class . '.class.php';
}

spl_autoload_register('sf_autoloader');

/**
 * detect mobile
 */
$detect = new MobileDetect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? TABLET : PHONE) : COMPUTER);
switch ($deviceType) {
    case TABLET:
        header("location:" . MOBILE_URL);
        break;
    case PHONE:
        header("location:" . MOBILE_URL);
        break;
    case COMPUTER:
        break;
    default:
        break;
}


/**
 * a new registry object
 */
$registry = new registry;

/**
 * load the router
 */
$registry->router = new router($registry);

/**
 * set the path to the controllers directory
 */
$registry->router->setPath(APP_PATH);
$registry->router->loader();
?>
<?php

/**
 * @author quyetnd
 */
class mvcCore
{
    /*
     * @the controller path
     */

    public $module;
    public $controller;
    public $action;
    private static $instance;

    function __construct()
    {
        /*         * * get the route from the url ** */
        $requestPath = (empty($_SERVER['REQUEST_URI'])) ? '' : $_SERVER['REQUEST_URI'];
        if (substr($requestPath, strlen($requestPath) - 1, strlen($requestPath) - 1) == "/") {
            $requestPath = substr($requestPath, 0, strlen($requestPath) - 1);
        }
        $this->model = baseModel::getInstance();
        $rewriteModel = $this->model->get('rewrite');
        $rewriteInfo = $rewriteModel->getRewriteInfo($requestPath);
        if (count($rewriteInfo) > 0) {
            $route = $rewriteInfo['target_path'];
        } else {
            $route = $requestPath;
        }
        $parts = explode('/', $route);
        array_shift($parts);

        if (empty($route)) {
            $route = 'default/index';
        } else {
            /* get the parts of the route */
            if (isset($parts[0])) {
                $this->module = $parts[0];
            }

            if (isset($parts[1])) {
                $this->controller = $parts[1];
            }
            if (isset($parts[2])) {
                $this->action = $parts[2];
            }
            if (isset($parts[3])) {
                $count_args = count($parts);
                $k = 1;
                $args = array();
                for ($i = 3; $i < $count_args; $i++)
                    $args[$k++] = $parts[$i];
                $this->args = $args;
            }
        }

        if (empty($this->module)) {
            $this->module = 'default';
        }

        if (empty($this->controller)) {
            $this->controller = 'index';
        }

        /* Get action */
        if (empty($this->action)) {
            $this->action = 'index';
        }
        $file = APP_PATH . '/modules/' . $this->module . '/controllers/' . $this->controller . 'Controller.php';
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new mvcCore();
        }
        return self::$instance;
    }

}

?>
<?php

/**
 * @author quyetnd
 */
class Request
{

    public static $instance = NULL;
    public $request = NULL; //default router

    /**
     *
     * @return Request 
     */

    public static function getInstance()
    {
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->request = $_REQUEST;
    }

    public function getRequestPath()
    {
        $requestPath = (empty($_SERVER['REQUEST_URI'])) ? '' : $_SERVER['REQUEST_URI'];
        if (substr($requestPath, strlen($requestPath) - 1, strlen($requestPath) - 1) == "/") {
            $requestPath = substr($requestPath, 0, strlen($requestPath) - 1);
        }
        return $requestPath;
    }

    public function queryString($key)
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
        if (empty($route)) {
            return null;
        } else {
            /*             * * get the parts of the route ** */
            $parts = explode('/', $route);
            array_shift($parts);
            if (isset($parts[3])) {
                $count_args = count($parts);
                for ($i = 3; $i < $count_args; $i++) {
                    if ($parts[$i] == $key) {
                        if (isset($parts[$i + 1])) {
                            return $parts[$i + 1];
                        }
                    }
                }
            }
        }
        return null;
    }

    public function getParam($param, $default = NULL)
    {
        return isset($this->request[$param]) ? $this->request[$param] : $default;
    }

    public function getParams()
    {
        $params = $this->request;
        //fix hosting cmc
        unset($params['__utma']);
        unset($params['__utmz']);
        unset($params['PHPSESSID']);
        unset($params['__utmb']);
        unset($params['__utmc']);

        return $params;
    }

    public function getPost($param, $default = NULL)
    {
        return isset($_POST[$param]) ? $_POST[$param] : $default;
    }

    public function isPost()
    {
        return !empty($_POST);
    }

}

?>
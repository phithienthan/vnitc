<?php

/**
 * @author quyetnd
 */
class router
{
    /*
     * @the registry
     */

    private $registry;

    /*
     * @the controller path
     */
    private $path;
    private $args = array();
    public $file;
    public $module;
    public $controller;
    public $action;
    protected $model;

    function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     *
     * @set controller directory path
     *
     * @param string $path
     *
     * @return void
     *
     */
    function setPath($path)
    {

        /*         * * check if path i sa directory ** */
        if (is_dir($path) == false) {
            throw new Exception('Invalid controller path: `' . $path . '`');
        }
        /*         * * set the path ** */
        $this->path = $path;
    }

    /**
     *
     * @load the controller
     *
     * @access public
     *
     * @return void
     *
     */
    public function loader()
    {
        /*         * * check the route ** */
        $this->getController();

        /*         * * if the file is not there diaf ** */
        if (is_readable($this->file) == false) {
            $this->module = 'error';
            $this->controller = 'error404';
            $this->file = $this->path . '/modules/' . $this->module . '/controllers' . '/' . $this->controller . 'Controller.php';
        }

        /*         * * include the controller ** */
        include $this->file;

        /*         * * a new controller class instance ** */
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);
        $action = $this->action;

        $action = $action . "Action";

        /*         * * check if the action is callable ** */
        if (is_callable(array($controller, $action)) == false) {
            $action = 'indexAction';
        } else {
            $action = $action;
        }

        /*         * * run the action ** */
        if (!empty($this->args))
            $controller->$action($this->args);
        else
            $controller->$action();
    }

    /**
     *
     * @get the controller
     *
     * @access private
     *
     * @return void
     *
     */
    private function getController()
    {
        $mvcCore = mvcCore::getInstance();
        $this->module = $mvcCore->module;
        $this->controller = $mvcCore->controller;
        $this->action = $mvcCore->action;
        $this->file = $this->path . '/modules/' . $this->module . '/controllers/' . $this->controller . 'Controller.php';
    }

}

?>
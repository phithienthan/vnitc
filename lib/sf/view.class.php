<?php

/**
 * @author quyetnd
 */
Class view
{
    /*
     * @Variables array
     * @access public
     */

    public $data = array();
    protected $module = null;
    protected $controller = null;
    protected $action = null;    

    /**
     *
     * @constructor
     *
     * @access public
     *
     * @return void
     *
     */
    function __construct()
    {
        $mvcCore = mvcCore::getInstance();
        $this->module = $mvcCore->module;
        $this->controller = $mvcCore->controller;
        $this->action = $mvcCore->action;
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
    public function block($name)
    {
        $path = APP_PATH . "/blocks/" . $this->module . "/" . $name . ".php";
        if (file_exists($path)) {
            include_once $path;
            $class = strtolower($this->module . "_block_" . $name);            
            $block = new $class($name);            
        }
    }
}

?>
<?php

/**
 * @author quyetnd
 */
Class baseView
{
    /*
     * @Variables array
     * @access public
     */

    public $data = array();
    public $content = null;
    public $layout = null;
    public $description = "";
    public $title = "";
    public $keywords = "";
    public $module = null;
    public $controller = null;
    public $action = null;
    private static $instance;

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

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new baseView();
        }
        return self::$instance;
    }

    /**
     *
     * @set undefined vars
     *
     * @param string $index
     *
     * @param mixed $value
     *
     * @return void
     *
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    public function block($name)
    {
        $path = APP_PATH . "/blocks/" . $this->module . "/" . $name . ".php";
        if (file_exists($path)) {
            include $path;
            $class = strtolower($this->module . "_block_" . $name);
            $block = new $class($name);
        }
    }

    public function set_layout($layout_name)
    {
        $this->layout = APP_PATH . "/layouts/$layout_name.phtml";
    }

    public function content()
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }
        include $this->content;
    }

    function show($name)
    {
        $path = APP_PATH . '/modules/' . $this->module . '/views' . '/' . $this->controller . '/' . $name . '.phtml';
        if (file_exists($path) == false) {
            $this->module = 'error';
            $this->controller = 'error404';
            $path = APP_PATH . '/modules/' . $this->module . '/views' . '/' . $this->controller . '/error404.phtml';
            if (file_exists($path) == false) {
                throw new Exception('Template not found in ' . $path);
                return false;
            }
        }
        $this->content = $path;
        include $this->layout;
    }

    /* SEO */

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($des)
    {
        $this->description = $des;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setKeywords($key)
    {
        $this->keywords = $key;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    /* END SEO */
}

?>
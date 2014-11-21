<?php

/**
 * @author quyetnd
 */
Class baseView extends view
{
    /*
     * @Variables array
     * @access public
     */
    
    public $content = null;
    public $layout = null;
    public $description = "";
    public $title = "";
    public $keywords = "";
    private static $instance;

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
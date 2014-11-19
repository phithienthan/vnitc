<?php

/**
 * @author quyetnd
 */
Abstract Class baseBlock
{

    public $data = array();
    protected $module;
    protected $model;
    protected $name;
    protected $request;

    function __construct($blockName)
    {
        $this->model = baseModel::getInstance();
        $mvcCore = mvcCore::getInstance();
        $this->module = $mvcCore->module;
        $this->name = $blockName;
        $this->request = request::getInstance();
        $this->init();
        $this->renderHtml();
    }

    abstract function init();

    public function renderHtml()
    {
        foreach ($this->data as $key => $value) {
            $$key = $value;
        }
        $path = APP_PATH . "/blocks/$this->module/$this->name.phtml";
        if (file_exists($path)) {
            include $path;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

}

?>
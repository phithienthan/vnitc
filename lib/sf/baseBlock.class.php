<?php

/**
 * @author quyetnd
 */
Abstract Class baseBlock extends view
{
    
    protected $model;
    protected $name;
    protected $request;

    function __construct($blockName)
    {
        parent::__construct();
        $this->model = baseModel::getInstance();
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
}

?>
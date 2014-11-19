<?php

/**
 * @author quyetnd
 */
Abstract Class baseController
{
    /*
     * @registry object
     */

    protected $registry;
    protected $model;
    protected $view;
    protected $request;

    function __construct($registry)
    {
        $this->registry = $registry;
        $this->model = baseModel::getInstance();
        $this->view = baseView::getInstance();
        $this->request = request::getInstance();

        $this->init();
    }

    abstract function init();

    /**
     * @all controllers must contain an index method
     */
    abstract function indexAction();

    public function redirect($url)
    {
        header("Location: $url");
    }

}

?>
<?php

/**
 * @author quyetnd
 */

Class indexController Extends defaultController
{

    public function indexAction()
    {
        $articleModel = $this->model->get('article');
        $articles = $articleModel->getByChannel(61, 1);
        $this->view->data['articles'] = $articles;

        $this->view->show('index');
        /* load layout template */
    }

}

?>
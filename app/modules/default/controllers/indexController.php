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
        
        // Get lastest product
        $productModel = $this->model->get('product');
        $products = $productModel->getHotProducts(24);
        $this->view->data['products'] = $products;
        
        $this->view->show('index');
        /* load layout template */
    }

}

?>
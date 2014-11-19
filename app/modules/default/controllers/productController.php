<?php

/**
 * @author quyetnd
 */

Class productController Extends defaultController
{

    public function indexAction()
    {
        
    }

    public function viewdetailAction()
    {
        $productModel = $this->model->get('product');
        $categoryModel = $this->model->get('category');
        $productId = $this->request->queryString("id");
        $product = $productModel->getProductInfo($productId, 1);
        $categoryId = $product['category_id'];
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        /*         * * set a template variable ** */
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['product'] = $product;

        $this->view->setTitle($product["pro_name"]);
        $this->view->setDescription($product["pro_name"]);
        $this->view->setKeywords($product["pro_name"]);
        /*         * * load the index template ** */
        $this->view->show('view_detail');
    }

    public function listAction()
    {
        $productModel = $this->model->get('product');
        $categoryModel = $this->model->get('category');
        $categoryId = $this->request->queryString("id");
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = 1;
        }
        $pageSize = 20;
        $products = $productModel->getAllByCategoryId($categoryId, $page, $pageSize);
        /*         * * set a template variable ** */
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['products'] = $products;

        $this->view->setTitle($categoryInfo["title"]);
        $this->view->setDescription($categoryInfo["title"]);
        $this->view->setKeywords($categoryInfo["title"]);
        /*         * * load the index template ** */
        $this->view->show('list');
    }

}

?>
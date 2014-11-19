<?php

/*
 * @author quyetnd
 */

Class articleController Extends defaultController
{

    public function indexAction()
    {
        
    }

    public function viewdetailAction()
    {
        $articleModel = $this->model->get('article');
        $categoryModel = $this->model->get('category');
        $articleId = $this->request->queryString("id");
        $article = $articleModel->getArticleInfo($articleId, 1);
        $categoryId = $article['category_id'];
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        /*         * * set a template variable ** */
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['article'] = $article;

        $this->view->setTitle($article["title"]);
        $this->view->setDescription($article["title"]);
        $this->view->setKeywords($article["title"]);
        /*         * * load the index template ** */
        $this->view->show('view_detail');
    }

    public function listAction()
    {
        $articleModel = $this->model->get('article');
        $categoryModel = $this->model->get('category');
        $categoryId = $this->request->queryString("id");
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = 1;
        }
        $pageSize = 20;
        $articles = $articleModel->getAllArticlesByCategoryId($categoryId, $page, $pageSize);
        /*         * * set a template variable ** */
        $this->view->data['categoryInfo'] = $categoryInfo;
        $this->view->data['articles'] = $articles;

        $this->view->setTitle($categoryInfo["title"]);
        $this->view->setDescription($categoryInfo["title"]);
        $this->view->setKeywords($categoryInfo["title"]);
        /*         * * load the index template ** */
        $this->view->show('list');
    }

}

?>
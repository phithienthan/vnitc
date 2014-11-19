<?php

/**
 * @author quyetnd
 */

Class aboutController Extends defaultController
{

    public function indexAction()
    {
        $articleModel = $this->model->get('article');
        $categoryModel = $this->model->get('category');

        $categoryId = $this->request->queryString("id");
        $article = $articleModel->getByChannel($categoryId, 1);
        if (count($article) == 0) {
            $article = null;
        }
        $this->view->data['article'] = $article[0];
        //var_dump($article);exit;
        $categoryInfo = $categoryModel->getCategoryInfo($categoryId);
        $this->view->data['categoryInfo'] = $categoryInfo;
        if ($article != null) {
            $this->view->setTitle($article[0]["title"]);
            $this->view->setDescription($article[0]["title"]);
            $this->view->setKeywords($article[0]["title"]);
        }

        $this->view->show('index');
        /* load layout template */
    }

}

?>
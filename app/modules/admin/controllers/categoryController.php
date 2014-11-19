<?php

/**
 * @author quyetnd
 */

Class categoryController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $pageSize = 20;
        $totalRecord = $this->model->get('category')->getTotalRecord();
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = $pageSize;
        $this->view->data['parentCategorys'] = $this->model->get('category')->getCategorys($page, $pageSize);

        $categoryGrid = new Grid($this->view->data['parentCategorys']);
        $categoryGrid->setModule('admin');
        $categoryGrid->setController('category');
        $categoryGrid->setTotalRecord($totalRecord);
        $categoryGrid->setPageSize($pageSize);
        $categoryGrid->addColumn(array(
            'header' => 'Tên chuyên mục',
            'align' => 'left',
            'width' => '',
            'index' => 'title'
        ));
        $categoryGrid->addColumn(array(
            'header' => 'URL key',
            'align' => 'left',
            'width' => '',
            'index' => 'url_key'
        ));
        $categoryGrid->addColumn(array(
            'header' => 'Mục cha',
            'align' => 'center',
            'width' => '60',
            'index' => 'parent_id'
        ));
        $categoryGrid->addColumn(array(
            'header' => 'Thứ tự',
            'align' => 'center',
            'width' => '60',
            'index' => 'sort_order'
        ));
        $this->view->data['grid'] = $categoryGrid;
        $this->view->show('index');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        $categoryTypeModel = $this->model->get('category_type');
        $categoryPosModel = $this->model->get('category_position');
        $positionModel = $this->model->get('position');

        $this->view->data['id'] = $id;
        $this->view->data['categoryInfo'] = $categoryModel->getCategoryInfo($id);
        $this->view->data['categoryTypes'] = $categoryTypeModel->getAllTypes();
        $this->view->data['catePoss'] = $catePos = $categoryPosModel->getCatePosByCateId($id);
        $this->view->data['categorys'] = $this->getAllCategory(0);
        $this->view->data['positions'] = $positionModel->getAllPositions();
        $this->view->show('edit');
    }

    public function getAllCategory($root_id)
    {
        $categorys = array();
        $categoryModel = $this->model->get('category');
        $parentCategory = $categoryModel->getCategoryByParentId($root_id);
        $i = 0;
        foreach ($parentCategory as $category) {
            $categorys[$i++] = $category;
            $childCategory = $categoryModel->getCategoryByParentId($category['id']);
            if (count($childCategory) > 0) {
                $items = $this->getAllCategory($category['id']);
                foreach ($items as $item) {
                    $categorys[$i++] = $item;
                }
            }
        }
        return $categorys;
    }

    public function postAction()
    {
        $params = $this->request->getParams();
        if ($params["url_key"] == "") {
            $params["url_key"] = $params["title"];
        }
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        $rewriteModel = $this->model->get('rewrite');
        $params["url_key"] = Helper::getInstance()->urlKey($params["url_key"], $id, $categoryModel->getTableName());
        $i = 1;
        $duplicate = Helper::getInstance()->rewriteDuplicate("/" . $params["url_key"], $id, $rewriteModel->getTableName(), "request_path");
        while ($duplicate) {
            $params["url_key"] .= "-" . $i++;
            $duplicate = Helper::getInstance()->rewriteDuplicate("/" . $params["url_key"], $id, $rewriteModel->getTableName(), "request_path");
        }
        $parentCategory = $categoryModel->getCategoryInfo($params["parent_id"]);
        if (count($parentCategory) == 0) {
            $params["level"] = 1;
        } else {
            $params["level"] = $parentCategory["level"] + 1;
        }

        $rewriteParams = array();
        $rewriteParams['request_path'] = "/" . $params['url_key'];
        switch ($params['type']) {
            case 'news':
                $rewriteParams['target_path'] = '/default/article/list/id/';
                break;
            case 'product':
                $rewriteParams['target_path'] = '/default/product/list/id/';
                break;
            case 'contact':
                $rewriteParams['target_path'] = '/default/feedback/index/id/';
                break;
            case 'about':
                $rewriteParams['target_path'] = '/default/about/index/id/';
                break;
            default:
                $rewriteParams['target_path'] = '/default/article/list/id/';
                break;
        }
        //Loai bo position
        $cateParams = array();
        $cateParams['title'] = $params['title'];
        $cateParams['url_key'] = $params['url_key'];
        $cateParams['sort_order'] = $params['sort_order'];
        $cateParams['type'] = $params['type'];
        $cateParams['parent_id'] = $params['parent_id'];
        $cateParams['meta_keywords'] = $params['meta_keywords'];
        $cateParams['meta_description'] = $params['meta_description'];
        $cateParams['level'] = $params['level'];

        if ($id == "") {
            $categoryModel->addNewCategory($cateParams);
            $categoryInfo = $categoryModel->getCategoryInfoByKey($params["url_key"]);

            $id = $categoryInfo['id'];
            $rewriteParams['target_path'] .= $id;
            $rewriteModel->addNewRewrite($rewriteParams);
        } else {
            $categoryInfo = $categoryModel->getCategoryInfo($id);
            if (($categoryInfo['url_key'] != $params['url_key']) || ($categoryInfo['type'] != $params['type'])) {
                $rewriteInfo = $rewriteModel->getRewriteInfo("/" . $categoryInfo['url_key']);
                $rewriteParams['target_path'] .= $id;
                $rewriteModel->updateRewrite($rewriteInfo['id'], $rewriteParams);
            }
            $categoryModel->updateCategory($id, $cateParams);
        }
        $category_posModel = $this->model->get('category_position');
        $catePos = $category_posModel->getCatePosByCateId($id);
        foreach ($catePos as $catePosition) {
            $category_posModel->deletePosCategory($catePosition['id']);
        }

        foreach ($params['position'] as $pos_id) {
            $catePosParams['category_id'] = $id;
            $catePosParams['position_id'] = $pos_id;
            $category_posModel->addNewCategoryPos($catePosParams);
        }

        $this->redirect("/admin/category/list");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        /* del category position before */
        $category_posModel = $this->model->get('category_position');
        $catePos = $category_posModel->getCatePosByCateId($id);
        foreach ($catePos as $catePosition) {
            $category_posModel->deletePosCategory($catePosition['id']);
        }
        /* end del category */
        /* del rewrite before */
        $rewriteModel = $this->model->get('rewrite');
        $cateInfo = $categoryModel->getCategoryInfo($id);
        $rewriteInfo = $rewriteModel->getRewriteInfo("/" . $cateInfo['url_key']);
        $rewriteModel->deleteRewrite($rewriteInfo['id']);
        /* end del rewrite */
        $categoryModel->deleteCategory($id);
        $this->redirect("/admin/category/list");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $categoryModel = $this->model->get('category');
        foreach ($para['chkItem'] as $id) {
            /* del category position before */
            $category_posModel = $this->model->get('category_position');
            $catePos = $category_posModel->getCatePosByCateId($id);
            foreach ($catePos as $catePosition) {
                $category_posModel->deletePosCategory($catePosition['id']);
            }
            /* end del category */
            /* del rewrite before */
            $rewriteModel = $this->model->get('rewrite');
            $cateInfo = $categoryModel->getCategoryInfo($id);
            $rewriteInfo = $rewriteModel->getRewriteInfo("/" . $cateInfo['url_key']);
            $rewriteModel->deleteRewrite($rewriteInfo['id']);
            /* end del rewrite */
            $categoryModel->deleteCategory($id);
        }
        $this->redirect("/admin/category/list");
    }

}

?>
<?php

/**
 * @author quyetnd
 */

Class positionController Extends adminController
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
        $this->view->show('index');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        $this->view->data['id'] = $id;
        $this->view->data['categoryInfo'] = $categoryModel->getCategoryInfo($id);
        $this->view->data['parentCategory'] = $this->getAllCategory(0);
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
        $params["url_key"] = Helper::getInstance()->urlKey($params["url_key"], $id, $categoryModel->getTableName());

        $parentCategory = $categoryModel->getCategoryInfo($params["parent_id"]);
        $params["level"] = $parentCategory["level"] + 1;

        if ($id == "") {
            $categoryModel->addNewCategory($params);
        } else {
            $categoryModel->updateCategory($id, $params);
        }
        $this->redirect("/admin/category/list");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        $categoryModel->deleteCategory($id);
        $this->redirect("/admin/category/list");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $categoryModel = $this->model->get('category');
        foreach ($para['chkItem'] as $id) {
            $categoryModel->deleteCategory($id);
        }
        $this->redirect("/admin/category/list");
    }

}

?>
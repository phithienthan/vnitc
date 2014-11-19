<?php

/**
 * @author quyetnd
 */

Class productController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $totalRecord = $this->model->get('product')->getTotalRecord();
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['products'] = $this->model->get('product')->getProducts($page, $this->view->data['pageSize']);

        $grid = new Grid($this->view->data['products']);
        $grid->setModule('admin');
        $grid->setController('product');
        $grid->setId('pro_id');
        $grid->setTotalRecord($totalRecord);
        $grid->setPageSize($this->view->data['pageSize']);
        $grid->setPage($page);
        $grid->addColumn(array(
            'header' => 'Tên sản phẩm',
            'align' => 'left',
            'width' => '',
            'index' => 'pro_name'
        ));
        $grid->addColumn(array(
            'header' => 'Url key',
            'align' => 'left',
            'width' => '',
            'index' => 'url_key'
        ));
        $grid->addColumn(array(
            'header' => 'Product category',
            'align' => 'center',
            'width' => '140',
            'index' => 'category_id'
        ));
        $grid->addColumn(array(
            'header' => 'Thứ tự',
            'align' => 'center',
            'width' => '60',
            'index' => 'priority'
        ));
        $this->view->data['grid'] = $grid;
        $this->view->show('index');
    }

    public function searchresultAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $key = $this->request->getParam('txtKey');
        if (!isset($key)) {
            $key = '';
        } else {
            $key = trim($key);
        }
        $totalRecord = $this->model->get('product')->getTotalResult($key);
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['products'] = $this->model->get('product')->getSearchResults($key, $page, $this->view->data['pageSize']);

        $grid = new Grid($this->view->data['products']);
        $grid->setModule('admin');
        $grid->setController('product');
        $grid->setTotalRecord($totalRecord);
        $grid->setPageSize($this->view->data['pageSize']);
        $grid->setPage($page);
        $grid->addColumn(array(
            'header' => 'Tiêu đề bài viết',
            'align' => 'left',
            'width' => '',
            'index' => 'title'
        ));
        $grid->addColumn(array(
            'header' => 'URL key',
            'align' => 'left',
            'width' => '',
            'index' => 'url_key'
        ));
        $grid->addColumn(array(
            'header' => 'Xuất bản',
            'align' => 'center',
            'width' => '140',
            'index' => 'public_time'
        ));
        $grid->addColumn(array(
            'header' => 'Thứ tự',
            'align' => 'center',
            'width' => '60',
            'index' => 'priority'
        ));
        $this->view->data['grid'] = $grid;
        $this->view->show('search');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $categoryModel = $this->model->get('category');
        $productModel = $this->model->get('product');
        $this->view->data['id'] = $id;
        $this->view->data['productInfo'] = $productModel->getProductInfo($id);
        $this->view->data['categorys'] = $this->getAllCategory(0);
        $this->view->show('edit');
    }

    public function getAllCategory($root_id)
    {
        $categorys = array();
        $categoryModel = $this->model->get('category');
        $parentCategory = $categoryModel->getParentProCate($root_id);
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
        $content = $params['pro_detail'];

        $content = html_entity_decode($content, ENT_NOQUOTES, 'UTF-8');
        $match = array();
        $split = preg_match('/<h1.*class="pTitle".*<\/h1>/siU', $content, $match);
        if ($split) {
            $title = preg_replace('/<h1.*class="pTitle".*>/siU', '', $match[0]);
            $params['pro_name'] = substr($title, 0, -5);
        }

        $split = preg_match('/<h2.*class="pHead".*<\/h2>/siU', $content, $match);
        if ($split) {
            $pro_des = preg_replace('/<h2.*class="pHead".*>/siU', '', $match[0]);
            $params['pro_des'] = substr($pro_des, 0, -5);
        }

        /* upload image */
        $avatarUrl = "";
        $newName = "";
        //var_dump($_FILES);exit;

        if ($_FILES["file"]["name"] != "") {
            $file_exts = array("jpg", "bmp", "jpeg", "gif", "png");
            $upload_exts = end(explode(".", $_FILES["file"]["name"]));
            if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2000000) && in_array($upload_exts, $file_exts)) {

                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                    die;
                } else {
                    // Enter your path to upload file here       
                    $avatarUrl = ROOT . AVATAR_PATH;
                    if (file_exists($avatarUrl . $_FILES["file"]["name"])) {
                        $newName = time() . $_FILES["file"]["name"];
                        $avatarUrl .= $newName;
                        move_uploaded_file($_FILES["file"]["tmp_name"], $avatarUrl);
                    } else {
                        $newName = $_FILES["file"]["name"];
                        $avatarUrl .= $newName;
                        move_uploaded_file($_FILES["file"]["tmp_name"], $avatarUrl);
                    }
                }
            } else {
                echo "<div class='error'>Invalid file</div>";
                die;
            }
            $params['pro_image'] = $newName;
            // *** 1) Initialise / load image
            $resizeObj = new resize($avatarUrl);
            // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
            $resizeObj->resizeImage(180, 110, 'crop');
            $savePath = ROOT . AVATAR_RESIZE_PATH;
            // *** 3) Save image
            $resizeObj->saveImage($savePath . "180x110/" . $newName, 100);
            // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
            $resizeObj->resizeImage(280, 200, 'crop');
            // *** 3) Save image
            $resizeObj->saveImage($savePath . "280x200/" . $newName, 100);
        }
        /* end upload image */
        $params["url_key"] = $params['pro_name'];
        $id = $this->request->queryString("id");
        $productModel = $this->model->get('product');
        $rewriteModel = $this->model->get('rewrite');

        $params["url_key"] = Helper::getInstance()->urlKey($params["url_key"], $id, $productModel->getTableName());
        $i = 1;
        $duplicate = Helper::getInstance()->rewriteDuplicate("/" . $params["url_key"], $id, $rewriteModel->getTableName(), "request_path");
        while ($duplicate) {
            $params["url_key"] .= "-" . $i++;
            $duplicate = Helper::getInstance()->rewriteDuplicate("/" . $params["url_key"], $id, $rewriteModel->getTableName(), "request_path");
        }
        $rewriteParams = array();
        $rewriteParams['request_path'] = "/" . $params['url_key'];

        $rewriteParams['target_path'] = '/default/product/viewdetail/id/';
        //$publicTime = $params['public_time'];
        //$publicTime = Helper::getInstance()->convertDate($params['public_time']);        
        //$params['public_time'] = $publicTime. " ".$params['sltH'].":".$params['sltM'].":00";        
        //unset($params['sltH']);
        //unset($params['sltM']);
        unset($params['file']);
        if ($id == "") {
            $productModel->addNew($params);
            //var_dump($params);exit;
            $productInfo = $productModel->getInfoByKey($params["url_key"]);
            $rewriteParams['target_path'] .= $productInfo['pro_id'];

            $rewriteModel->addNewRewrite($rewriteParams);
        } else {
            $productInfo = $productModel->getProductInfo($id);
            if ($productInfo['url_key'] != $params['url_key']) {
                $rewriteInfo = $rewriteModel->getRewriteInfo("/" . $productInfo['url_key']);
                $rewriteParams['target_path'] .= $id;
                $rewriteModel->updateRewrite($rewriteInfo['id'], $rewriteParams);
            }
            $productModel->update($id, $params);
        }
        $this->redirect("/admin/product/list");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $productModel = $this->model->get('product');
        $productModel->delete($id);
        $this->redirect("/admin/product/list");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $productModel = $this->model->get('product');
        foreach ($para['chkItem'] as $id) {
            $productModel->delete($id);
        }
        $this->redirect("/admin/product/list");
    }

}

?>
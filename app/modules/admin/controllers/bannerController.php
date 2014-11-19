<?php

/**
 * @author quyetnd
 */

Class bannerController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $bannerModel = $this->model->get('banner');
        $totalRecord = $bannerModel->getTotalRecord(1);
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['banners'] = $bannerModel->getBanner($page, $this->view->data['pageSize'], null);
        $grid = new Grid($this->view->data['banners']);
        $grid->setModule('admin');
        $grid->setController('banner');
        $grid->setTotalRecord($totalRecord);
        $grid->setPageSize($this->view->data['pageSize']);
        $grid->setPage($page);
        $grid->addColumn(array(
            'header' => 'ID',
            'align' => 'center',
            'width' => '',
            'index' => 'id'
        ));
        $grid->addColumn(array(
            'header' => 'Tên banner',
            'align' => 'left',
            'width' => '',
            'index' => 'title'
        ));
        $grid->addColumn(array(
            'header' => 'Link',
            'align' => 'center',
            'width' => '',
            'index' => 'link'
        ));

        $this->view->data['grid'] = $grid;
        $this->view->show('index');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $bannerModel = $this->model->get('banner');
        $this->view->data['id'] = $id;
        $this->view->data['bannerInfo'] = $bannerModel->getBannerInfo($id);

        $this->view->show('edit');
    }

    public function postAction()
    {
        $params = $this->request->getParams();
        //var_dump($params);exit;
        /* upload image */
        $avatarUrl = "";
        $newName = "";
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
            $params['img_path'] = $newName;
            // *** 1) Initialise / load image
            //$resizeObj = new resize($avatarUrl);            
            // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
            //$resizeObj -> resizeImage(1900, 300, 'crop');
            //$savePath = ROOT.AVATAR_RESIZE_PATH;
            // *** 3) Save image
            //$resizeObj -> saveImage($savePath."1900x300/".$newName, 100);            
            // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
            //$resizeObj -> resizeImage(280, 200, 'crop');
            // *** 3) Save image
            //$resizeObj -> saveImage($savePath."280x200/".$newName, 100);            
        }
        /* end upload image */
        $id = $this->request->queryString("id");
        $bannerModel = $this->model->get('banner');
        unset($params['file']);
        //var_dump($params);exit;
        if ($id == "") {
            $bannerModel->addNewBanner($params);
        } else {
            $bannerModel->updateBanner($id, $params);
        }
        $this->redirect("/admin/banner/index");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $model = $this->model->get('banner');
        $model->delete($id);
        $this->redirect("/admin/banner/index");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $model = $this->model->get('banner');
        foreach ($para['chkItem'] as $id) {
            $model->delete($id);
        }
        $this->redirect("/admin/banner/index");
    }

}

?>
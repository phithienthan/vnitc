<?php

/**
 * @author quyetnd
 */

Class linkController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $model = $this->model->get('link');
        $totalRecord = $model->getTotalRecord(1);
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['links'] = $model->getListByPaging($page, $this->view->data['pageSize'], null);
        $grid = new Grid($this->view->data['links']);
        $grid->setModule('admin');
        $grid->setController('link');
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
            'header' => 'Tên liên kết',
            'align' => 'left',
            'width' => '',
            'index' => 'title'
        ));
        $grid->addColumn(array(
            'header' => 'Đường dẫn',
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
        $model = $this->model->get('link');
        $this->view->data['id'] = $id;
        $this->view->data['linkInfo'] = $model->getInfo($id);

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
        }
        /* end upload image */
        $id = $this->request->queryString("id");
        $model = $this->model->get('link');
        unset($params['file']);        
        if ($id == "") {
            $model->addNew($params);
        } else {
            $model->update($id, $params);
        }
        $this->redirect("/admin/link/index");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $model = $this->model->get('link');
        $model->delete($id);
        $this->redirect("/admin/link/index");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $model = $this->model->get('link');
        foreach ($para['chkItem'] as $id) {
            $model->delete($id);
        }
        $this->redirect("/admin/link/index");
    }

}

?>
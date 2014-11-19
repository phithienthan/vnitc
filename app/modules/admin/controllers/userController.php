<?php

/**
 * @author quyetnd
 */

Class userController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $userModel = $this->model->get('user');
        $totalRecord = $userModel->getTotalRecord(1);
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['users'] = $userModel->getUser($page, $this->view->data['pageSize'], null);
        $grid = new Grid($this->view->data['users']);
        $grid->setModule('admin');
        $grid->setController('user');
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
            'header' => 'Tên truy cập',
            'align' => 'left',
            'width' => '',
            'index' => 'username'
        ));
        $grid->addColumn(array(
            'header' => 'Tên hiển thị',
            'align' => 'center',
            'width' => '',
            'index' => 'display_name'
        ));
        $grid->addColumn(array(
            'header' => 'Email',
            'align' => 'center',
            'width' => '',
            'index' => 'email'
        ));
        $this->view->data['grid'] = $grid;
        $this->view->show('index');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $userModel = $this->model->get('user');
        $this->view->data['id'] = $id;
        $this->view->data['userInfo'] = $userModel->getUserInfo($id);

        $this->view->show('edit');
    }

    public function postAction()
    {
        $params = $this->request->getParams();
        $id = $this->request->queryString("id");
        $userModel = $this->model->get('user');
        if ($id == "") {
            $params['password'] = md5($params['password']);
            $userModel->addNewUser($params);
        } else {
            $userInfo = $userModel->getUserInfo($id);
            if ($userInfo['password'] != $params['password']) {
                $params['password'] = md5($params['password']);
            }
            $userModel->updateUser($id, $params);
        }
        $this->redirect("/admin/user/index");
    }

    public function deleteAction()
    {
        $id = $this->request->queryString("id");
        $model = $this->model->get('user');
        $model->deleteUser($id);
        $this->redirect("/admin/user/index");
    }

    public function delAllAction()
    {
        $para = $this->request->getParams();
        $model = $this->model->get('user');
        foreach ($para['chkItem'] as $id) {
            $model->deleteUser($id);
        }
        $this->redirect("/admin/user/index");
    }

}

?>
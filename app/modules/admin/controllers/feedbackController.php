<?php

/**
 * @author quyetnd
 */

Class feedbackController Extends adminController
{

    public function indexAction()
    {
        $page = $this->request->queryString("page");
        if (empty($page)) {
            $page = "1";
        }
        $model = $this->model->get('feedback');
        $totalRecord = $model->getTotalRecord(1);
        $this->view->data['page'] = $page;
        $this->view->data['totalRecord'] = $totalRecord;
        $this->view->data['pageSize'] = 10;
        $this->view->data['users'] = $model->getAll($page, $this->view->data['pageSize'], null);
        $grid = new Grid($this->view->data['users']);
        $grid->setModule('admin');
        $grid->setController('feedback');
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
            'header' => 'Họ tên',
            'align' => 'left',
            'width' => '',
            'index' => 'fullname'
        ));
        $grid->addColumn(array(
            'header' => 'Thư điện tử',
            'align' => 'center',
            'width' => '',
            'index' => 'email'
        ));
        $grid->addColumn(array(
            'header' => 'Điện thoại',
            'align' => 'center',
            'width' => '',
            'index' => 'phone'
        ));
        $this->view->data['grid'] = $grid;
        $this->view->show('index');
    }

    public function editAction()
    {
        $id = $this->request->queryString("id");
        $model = $this->model->get('feedback');
        $this->view->data['feedbackInfo'] = $model->getInfo($id);
        $this->view->show('edit');
    }

    public function postAction()
    {
        $params = $this->request->getParams();
        $id = 1;
        $contactModel = $this->model->get('contact');
        if ($id == "") {
            $contactModel->addNewContact($params);
        } else {
            $contactModel->updateContact($id, $params);
        }
        $this->redirect("/admin/contact/edit");
    }

    public function feedbackAction()
    {
        $params = $this->request->getParams();
        $id = 1;
        $contactModel = $this->model->get('contact');
        if ($id == "") {
            $contactModel->addNewContact($params);
        } else {
            $contactModel->updateContact($id, $params);
        }
        $this->redirect("/admin/contact/edit");
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
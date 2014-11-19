<?php

/**
 * @author quyetnd
 */

Class authController Extends baseController
{

    public function init()
    {
        if (Auth::isLogin()) {
            $this->redirect('/admin');
        }
        $this->view->set_layout('login_layout');
    }

    public function indexAction()
    {
        /* load the index template */
        $this->view->show('index');
    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $username = $this->request->getParam('username', '');
            $password = $this->request->getParam('password', '');
            if (Auth::getInstance()->checkLogin($username, $password)) {
                $this->redirect('/admin');
            } else {
                $this->redirect('/admin/auth');
            }
        }
    }

    public function logoutAction()
    {
        Auth::logout();
        $this->redirect('/admin/auth');
    }

}

?>
<?php

/**
 * @author quyetnd
 */
Class adminController Extends baseController
{

    public function init()
    {
        if (!Auth::isLogin()) {
            $this->redirect('/admin/auth');
        }
        $this->view->set_layout('admin_layout');
    }

    public function indexAction()
    {
        
    }

}

?>
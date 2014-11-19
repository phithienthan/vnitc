<?php

/**
 * @author quyetnd
 */

Class error404Controller Extends defaultController
{

    public function indexAction()
    {
        $this->view->data['blog_heading'] = 'This is the 404';
        $this->view->show('error404');
    }

}

?>
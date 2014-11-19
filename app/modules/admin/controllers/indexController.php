<?php

/**
 * @author quyetnd
 */

Class indexController Extends adminController
{

    public function indexAction()
    {
        /* set a template variable */
        $this->view->data['welcome'] = 'a!';
        /* load the index template */
        $this->view->show('index');
        /* load layout template */
    }

}

?>
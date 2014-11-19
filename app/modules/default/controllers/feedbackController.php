<?php

/**
 * @author quyetnd
 */

Class feedbackController Extends defaultController
{

    public function indexAction()
    {
        $this->view->show('index');
        /* load layout template */
    }

    public function postAction()
    {
        $model = $this->model->get('feedback');
        $params = $this->request->getParams();
        $model->addNew($params);
        $this->redirect("/default/feedback/success");
    }

    public function successAction()
    {
        $this->view->show('success');
    }

}

?>
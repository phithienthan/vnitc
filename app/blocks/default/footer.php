<?php
/**
 * @author quyetnd
 */

class default_block_footer Extends baseBlock{    
    public function init(){
        $contactModel = $this->model->get('contact');
        $contactInfo = $contactModel->getContactInfo(1);
        $this->data['footer'] = $contactInfo['footer'];                   
    }
}

?>
<?php
/**
 * @author quyetnd
 */

class default_block_footer Extends baseBlock{    
    public function init(){
        $contactModel = $this->model->get('contact');
        $contactInfo = $contactModel->getContactInfo(1);
        $this->data['footer'] = $contactInfo['footer'];   
        
        $categoryModel = $this->model->get('category');
        $this->data['categorys'] = $categoryModel->getByParentIdAndPost(0,2);        
    }
}

?>
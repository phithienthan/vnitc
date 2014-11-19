<?php
/**
 * @author quyetnd
 */

class default_block_category Extends baseBlock{    
    public function init(){
        $categoryModel = $this->model->get('category');
        $this->data['categorys'] = $categoryModel->getCateByTypePost('product',6);
    }
}

?>
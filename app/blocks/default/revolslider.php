<?php
/**
 * @author quyetnd
 */

class default_block_revolslider Extends baseBlock{    
    public function init(){
        $bannerModel = $this->model->get('banner');
        $banners = $bannerModel->getBanner(1,10);
        $this->data['banners'] = $banners;            
    }
}

?>
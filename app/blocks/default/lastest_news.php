<?php
/**
 * @author quyetnd
 */

class default_block_lastest_news Extends baseBlock{    
    public function init(){
        $articleModel = $this->model->get('article');
        $this->data['lastestNews'] = $articleModel->getArticles(1,5);
    }
}

?>
<?php
/**
 * @author quyetnd
 */

class default_block_left Extends baseBlock{    
    public function init(){
        $articles = $this->model->get('article')->getLatestArticles(5);
        $this->data['articles'] = $articles;
    }
}

?>
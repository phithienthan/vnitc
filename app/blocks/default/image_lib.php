<?php

    /**
     * @author quyetnd
     */

    class default_block_image_lib Extends baseBlock {

        public function init() {
            $requestPath = $this->request->getRequestPath();
            $categoryModel = $this->model->get('category');
            $parentCategorys = $categoryModel->getByParentIdAndPost(0,1);
            $menuHtml = "";
            if (count($parentCategorys) > 0) {                
                foreach ($parentCategorys as $parentCategory) {
                    $menuHtml .= "<li><a href=\"/" . $parentCategory['url_key'] . "/\">" . $parentCategory['title'] . "</a></li><li><img src=" . SKIN_PATH . "default/images/line.jpg /></li>";
                }                
            }            
            $this->data['menuHtml'] = $menuHtml;
        }

    }

?>
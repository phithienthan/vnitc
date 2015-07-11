<?php

    /**
     * @author quyetnd
     */

    class default_block_menu_left Extends baseBlock {

        public function init() {
            $categoryModel = $this->model->get('category');
            $parentCategorys = $categoryModel->getByPost(3);           
            $this->data['categories'] = $parentCategorys;
        }

    }

?>
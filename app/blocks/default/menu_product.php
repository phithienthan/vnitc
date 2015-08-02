<?php

    /**
     * @author quyetnd
     */

    class default_block_menu_product Extends baseBlock {

        public function init() {
            $currentCateId = $this->request->queryString("id");            
            $requestPath = $this->request->getRequestPath();
            $categoryModel = $this->model->get('category');
            // Get parent category
            $parentCategorys = $categoryModel->getByParentIdAndPost(0,1);
            $menuHtml = "";
            $subMenu = "";
            // Set active
            $scriptActive = "<script type=\"text/javascript\">ddtabmenu.definemenu(\"ddtabs4\",";
            $menuActive = 0;
            $j = 0;
            if (count($parentCategorys) > 0) {                    
                foreach ($parentCategorys as $parentCategory) {
                    $menuHtml .= "<div class=\"TitleLeft1\">";
                    $menuHtml .= "";
                    $categoryChildren = $categoryModel->getCategoryByParentId($parentCategory['id']);
                    $menuHtml .= "</div>";
                }                     
            }  
            
            $scriptActive .= $menuActive;
            $scriptActive .= ")</script>";
            
            $this->data['menuHtml'] = $menuHtml;
            $this->data['subMenu'] = $subMenu;
            $this->data['scriptActive'] = $scriptActive;
        }

    }

?>
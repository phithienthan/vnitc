<?php

    /**
     * @author quyetnd
     */

    class default_block_menu_product Extends baseBlock {

        public function init() {
            $categoryModel = $this->model->get('category');
            // Get parent category (level 1)           
            $parentCategorys = $categoryModel->getByParentIdAndPost(0,6);
            $menuHtml = "";                          
            $j = 0;
            if (count($parentCategorys) > 0) {                                 
                foreach ($parentCategorys as $parentCategory) {   
                    $menuHtml   .= "<div class=\"BoxLeft\">";
                    $menuHtml .= "<div class=\"TitleLeft\">";                    
                    $menuHtml .= $parentCategory['title'];
                    $menuHtml .= "</div>";
                    $menuHtml .= "<div class=\"MenuLItem\"></div>";
                    // Level 2
                    $categoryChildren = $categoryModel->getCategoryByParentId($parentCategory['id']);
                    if(count($categoryChildren) > 0){
                        foreach ($categoryChildren as $categoryChild) {                    
                            $menuHtml .= "<div id=\"DivMenu\">";
                            $menuHtml .= "<ul><li>";
                            $menuHtml .= "<div style=\"width: 220px;\">";
                            $menuHtml .= "<a href=\"". $categoryChild['url_key']. "\">". $categoryChild['title'] . "</a>";
                            $menuHtml .= "</div>";
                            
                            // Level 3
                            $cateChildren = $categoryModel->getCategoryByParentId($categoryChild['id']);
                            if(count($cateChildren) > 0){
                                $menuHtml .= "<ul style=\"z-index: 10; width: 180px; margin-left: 150px; display: none;\" class=\"ulVMenu\">";
                                $menuHtml .= "<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" bgcolor=\"#F5F1F0\" style=\"border: 1px solid rgb(169, 169, 169);\">";
                                $menuHtml .= "<tbody>";                                
                                foreach ($cateChildren as $cateChild) {
                                    $menuHtml .= "<tr><td><a href=\"". $cateChild['url_key']. "\">";
                                    $menuHtml .= $cateChild['title']."</a></td></tr>";                                                                                                           
                                }
                                $menuHtml .= "</tbody></table></ul>";
                            }
                            $menuHtml .= "</ul></li>";                                       
                            $menuHtml .= "</div>";
                            $menuHtml .= "<script language=\"JavaScript\">initialiseMenu();</script>";
                        }
                    }
                    $menuHtml .= "</div>";
                }                                     
            }  
                       
            $this->data['menuHtml'] = $menuHtml;
        }

    }

?>
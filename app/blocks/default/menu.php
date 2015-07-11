<?php

    /**
     * @author quyetnd
     */

    class default_block_menu Extends baseBlock {

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
                    $j++;
                    $menuHtml .= "<li style=\"width:1px; height:35px; background:#FFF url(". SKIN_PATH ."default/plugins/tabmenu/media/bg-menu-horizontal-line.jpg) no-repeat scroll 0 0;\"></li>";
                    $menuHtml .= "<li><a href=\"/" . $parentCategory['url_key']. "\" rel=\"ct". $parentCategory['id'] ."\"><span>" . $parentCategory['title'] . "</span></a></li>";
                    // Get category children
                    $categoryChildren = $categoryModel->getCategoryByParentId($parentCategory['id']);                    
                    $subMenu .= "<div id=\"ct" . $parentCategory['id'] . "\" class=\"tabcontent\">";                
                    if($currentCateId == $parentCategory['id']){
                        $menuActive = $j;
                    }
                    if(count($categoryChildren)>0){   
                        $i = 0;
                        foreach($categoryChildren as $categoryChild){                              
                            $subMenu .= "<a href=\"". $categoryChild['url_key'] ."\">".$categoryChild['title']."</a>";
                            $i++;
                            if($i < count($categoryChildren)){
                                $subMenu .= "<span style=\"margin:0 5px 0 5px;\">|</span>";
                            }
                            if($currentCateId == $categoryChild['id']){
                                $menuActive = $j;
                            }                            
                        }                                                 
                    } else {
                        $subMenu .= DEFAULT_TITLE;
                    }      
                    $subMenu .= "</div>";
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
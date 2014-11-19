<?php

    /**
     * @author quyetnd
     */

    class default_block_header Extends baseBlock {

        public function init() {
            $requestPath = $this->request->getRequestPath();
            $categoryModel = $this->model->get('category');
            $parentCategorys = $categoryModel->getByParentIdAndPost(0,1);
            $menuHtml = "";
            if (count($parentCategorys) > 0) {                
                foreach ($parentCategorys as $parentCategory) {
                    $menuHtml .= "<td><a href=\"/" . $parentCategory['url_key'] . "/\">" . $parentCategory['title'] . "</a></td><td width=1><img src=" . SKIN_PATH . "default/images/bg-menu-line.gif></td>";
                }                
            }
            $this->data['menuHtml'] = $menuHtml;
            //hotline
            $contactModel = $this->model->get('contact');
            $contactInfo = $contactModel->getContactInfo(1);
            $this->data['hotline'] = $contactInfo['hotline'];
        }

    }

?>
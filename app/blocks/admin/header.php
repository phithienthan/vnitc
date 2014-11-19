<?php
/**
 * @author quyetnd
 */

class admin_block_header Extends baseBlock{    
    public function init(){
        $doc = new DOMDocument();
        $doc->load(CONFIG . 'admin_menu.xml');
        $menus = $doc->getElementsByTagName("items");
        $menuHtml = "";
        if(count($menus)>0){
            $menuHtml = "<ul>";
            foreach ($menus as $menu) { 
                $title = $menu->getElementsByTagName("title");
                $menuHtml .= "<li><a href=\"#\">".$title->item(0)->nodeValue."</a>";

                $childs = $menu->getElementsByTagName("children");
                if ($childs->length > 0) {
                    $menuHtml .= "<ul>";                
                    foreach ($childs as $child) {
                        $title_child = $child->getElementsByTagName("title");
                        $link_child = $child->getElementsByTagName("action");
                            $menuHtml .= "<li><a href=\"/admin/".$link_child ->item(0)->nodeValue."/\">".$title_child->item(0)->nodeValue."</a>";                    
                    }  
                    $menuHtml .= "</ul>"; 
                }
                $menuHtml .= "</li>";                
            }
            $menuHtml .= "<li class=\"last\"></li>";
            $menuHtml .= "</ul>";
        }
        $this->data['menuHtml'] = $menuHtml;
    }
}

?>
<?php
/**
 * @author quyetnd
 */

Class articleModel Extends baseModel {

    private $_table = 'sf_article';
    
    public function getTableName(){
        return $this->_table;
    }
    public function getAllArticles() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getArticleInfo($id,$status = NULL) {
        if($status == NULL){
            $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        } else {
            $qr = 'SELECT * FROM ' . $this->_table . ' where status = '.$status.' and id = ' . $this->_mysql->quote($id);
        }
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getArticleInfoByKey($key) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where url_key = ' . $this->_mysql->quote($key);        
        $detail = $this->_mysql->execute_query_to_array($qr);
        if (count($detail) > 0) {
            $detail = $detail[0];
        }
        return $detail;
    }
    
    public function getByChannel($channel,$top) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where status=1 and category_id = ' . $this->_mysql->quote($channel) .' LIMIT 0,'. $top;
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }
    
    public function getArticles($page,$pageSize,$status=NULL) {
        $page = $this->_mysql->quote($page);        
        if($status==NULL){
            $qr = 'SELECT * FROM ' . $this->_table.' ORDER BY id DESC LIMIT '.($page-1)*$pageSize. ','. $pageSize;        
        } else {
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE status ='. $status.' ORDER BY id DESC LIMIT '.($page-1)*$pageSize. ','. $pageSize;
        }
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }
    
    public function getHotArticles($pageSize,$status=NULL) {     
        if($status==NULL){
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE priority=-1 ORDER BY id DESC LIMIT 0,'. $pageSize;        
        } else {
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE status ='. $status.' AND priority=-1 ORDER BY id DESC LIMIT 0,'. $pageSize;
        }
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    public function getLatestArticles($pageSize,$status=NULL) {     
        if($status==NULL){
            $qr = 'SELECT * FROM ' . $this->_table.'  ORDER BY id DESC LIMIT 0,'. $pageSize;        
        } else {
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE status ='. $status.' ORDER BY id DESC LIMIT 0,'. $pageSize;
        }
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }
    
    public function getAllArticlesByCategoryId($categoryId,$page,$pageSize) {                
        $page = $this->_mysql->quote($page);        
        $qr = 'SELECT * FROM ' . $this->_table.' WHERE status=1 and category_id = '. $categoryId .' LIMIT '.($page-1)*$pageSize. ','. $pageSize;                
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }    
    
    public function getTotalRecord() {    
        $result = mysql_query( "select count(id) as num_rows from ". $this->_table );
        $row = mysql_fetch_object( $result );
        $total = $row->num_rows;        
        return $total;
    }        

    public function addNewArticle($params) {        
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateArticle($id, $params) {
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteArticle($id) {
        return $this->_mysql->delete($this->_table, $id);
    }
    /* search */
    public function getTotalResult($key) {    
        $result = mysql_query( "select count(id) as num_rows from ". $this->_table ." where title like '%". $key . "%'");
        $row = mysql_fetch_object( $result );
        $total = $row->num_rows;        
        return $total;
    }         
    public function getSearchResults($key,$page,$pageSize) {
        $page = $this->_mysql->quote($page);        
        $qr = 'SELECT * FROM ' . $this->_table." where title like '%". $key ."%' LIMIT ".($page-1)*$pageSize. ','. $pageSize;        
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }    
    /* end search */
}

?>
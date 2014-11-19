<?php

/**
 * @author quyetnd
 */

Class productModel Extends baseModel {

    private $_table = 'sf_product';

    public function getTableName() {
        return $this->_table;
    }

    public function getAllProducts() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getProductInfo($id) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where pro_id = ' . $this->_mysql->quote($id);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getInfoByKey($key) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where url_key = ' . $this->_mysql->quote($key);
        $detail = $this->_mysql->execute_query_to_array($qr);
        if (count($detail) > 0) {
            $detail = $detail[0];
        }
        return $detail;
    }

    
    public function getAllByCategoryId($categoryId,$page,$pageSize) {                
        $page = $this->_mysql->quote($page);        
        $qr = 'SELECT * FROM ' . $this->_table.' WHERE Visible=1 and category_id = '. $categoryId .' LIMIT '.($page-1)*$pageSize. ','. $pageSize;        
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    } 
    
    public function getProducts($page, $pageSize) {
        $page = $this->_mysql->quote($page);
        $qr = 'SELECT * FROM ' . $this->_table . ' LIMIT ' . ($page - 1) * $pageSize . ',' . $pageSize;
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }
    
    public function getHotProducts($pageSize,$status=NULL) {     
        if($status==NULL){
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE priority=-1 ORDER BY pro_id DESC LIMIT 0,'. $pageSize;        
        } else {
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE Visible ='. $status.' AND priority=-1 ORDER BY pro_id DESC LIMIT 0,'. $pageSize;
        }       
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }
    
    public function getTotalRecord() {
        $result = mysql_query("select count(pro_id) as num_rows from " . $this->_table);
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function addNew($params) {
        return $this->_mysql->insert($this->_table, $params);
    }

    public function update($id, $params) {
        return $this->_mysql->update($this->_table, $id, $params, 'pro_id');
    }

    public function delete($id) {
        return $this->_mysql->delete($this->_table, $id, 'pro_id');
    }

    /* search */

    public function getTotalResult($key) {
        $result = mysql_query("select count(pro_id) as num_rows from " . $this->_table . " where title like '%" . $key . "%'");
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function getSearchResults($key, $page, $pageSize) {
        $page = $this->_mysql->quote($page);
        $qr = 'SELECT * FROM ' . $this->_table . " where title like '%" . $key . "%' LIMIT " . ($page - 1) * $pageSize . ',' . $pageSize;
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    /* end search */
}

?>
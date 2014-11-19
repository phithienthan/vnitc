<?php

/**
 * @author quyetnd
 */

Class rewriteModel Extends baseModel {

    private $_table = 'sf_rewrite';

    public function getTableName() {
        return $this->_table;
    }

    public function getAllRewrites() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getRewriteInfoById($id) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getRewriteInfo($requestPath) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where request_path = ' . $this->_mysql->quote($requestPath);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getCategoryByParentId($parent_id) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where parent_id = ' . $this->_mysql->quote($parent_id). ' order by sort_order ASC';
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getCategorys($page,$pageSize) {
        $page = $this->_mysql->quote($page);        
        $qr = 'SELECT * FROM ' . $this->_table.' LIMIT '.($page-1)*$pageSize. ','. $page*$pageSize;
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }
    public function getTotalRecord() {    
        $result = mysql_query( "select count(id) as num_rows from ". $this->_table );
        $row = mysql_fetch_object( $result );
        $total = $row->num_rows;        
        return $total;
    }    

    public function addNewRewrite($params) {
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateRewrite($id, $params) {        
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteRewrite($id) {
        return $this->_mysql->delete($this->_table, $id);
    }

}

?>
<?php

/**
 * @author quyetnd
 */

Class positionModel Extends baseModel {

    private $_table = 'sf_position';

    public function getTableName() {
        return $this->_table;
    }

    public function getAllPositions() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getCategoryInfo($id) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getCategoryInfoByKey($url_key) {
        $qr = 'SELECT * FROM ' . $this->_table . ' where url_key = ' . $this->_mysql->quote($url_key);
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

    public function addNewCategory($params) {
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateCategory($id, $params) {        
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteCategory($id) {
        return $this->_mysql->delete($this->_table, $id);
    }

}

?>
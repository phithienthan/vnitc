<?php
/**
 * @author quyetnd
 */

Class linkModel Extends baseModel {

    private $_table = 'sf_link';
    
    public function getTableName(){
        return $this->_table;
    }
    public function getAll() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getInfo($id,$status = NULL) {
        if($status == NULL){
            $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        } else {
            $qr = 'SELECT * FROM ' . $this->_table . ' where status = '.$status.' id = ' . $this->_mysql->quote($id);
        }
        $banner_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($banner_detail) > 0) {
            $banner_detail = $banner_detail[0];
        }
        return $banner_detail;
    }
    
    public function getListByPaging($page,$pageSize,$status=NULL) {
        $page = $this->_mysql->quote($page);        
        if($status==NULL){
            $qr = 'SELECT * FROM ' . $this->_table.' ORDER BY id DESC LIMIT '.($page-1)*$pageSize. ','. $pageSize;        
        } else {
            $qr = 'SELECT * FROM ' . $this->_table.' WHERE status ='. $status.' ORDER BY id DESC LIMIT '.($page-1)*$pageSize. ','. $pageSize;
        }
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }   
    
    public function getTotalRecord($status = NULL) {
        if ($status == NULL) {
            $result = mysql_query("select count(id) as num_rows from " . $this->_table);
        } else {
            $result = mysql_query("select count(id) as num_rows from " . $this->_table . " WHERE status=1");
        }
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function addNew($params) {        
        return $this->_mysql->insert($this->_table, $params);
    }

    public function update($id, $params) {
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function delete($id) {
        return $this->_mysql->delete($this->_table, $id);
    }
    /* search */
    public function getTotalResult($key) {    
        $result = mysql_query( "select count(id) as num_rows from ". $this->_table ." where title like '%". $key . "%'");
        $row = mysql_fetch_object( $result );
        $total = $row->num_rows;        
        return $total;
    }         
    /* end search */
}

?>
<?php
/**
 * @author quyetnd
 */

Class contactModel Extends baseModel {

    private $_table = 'sf_contact_info';
    
    public function getTableName(){
        return $this->_table;
    }
    public function getAllContact() {
        return $this->_mysql->select_all($this->_table);
    }

    public function getContactInfo($id,$status = NULL) {
        if($status == NULL){
            $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        } else {
            $qr = 'SELECT * FROM ' . $this->_table . ' where status = '.$status.' id = ' . $this->_mysql->quote($id);
        }
        $contact_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($contact_detail) > 0) {
            $contact_detail = $contact_detail[0];
        }
        return $contact_detail;
    }
    
    public function getContact($page,$pageSize,$status=NULL) {
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

    public function addNewContact($params) {        
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateContact($id, $params) {
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteContact($id) {
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
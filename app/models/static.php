<?php

/**
 * @author quyetnd
 */

Class staticModel Extends baseModel {

    private $_table = 'sf_static_visitor';

    public function getTableName() {
        return $this->_table;
    } 

    public function addNewPageView($params) {
        return $this->_mysql->insert($this->_table, $params);
    }

}

?>
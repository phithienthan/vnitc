<?php

/**
 * @author quyetnd
 */
Class userModel Extends baseModel
{

    private $_table = 'sf_users';

    public function getTableName()
    {
        return $this->_table;
    }

    public function getAllUser()
    {
        return $this->_mysql->select_all($this->_table);
    }

    public function getUserInfo($id, $status = NULL)
    {
        if ($status == NULL) {
            $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        } else {
            $qr = 'SELECT * FROM ' . $this->_table . ' where status = ' . $status . ' id = ' . $this->_mysql->quote($id);
        }
        $user_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($user_detail) > 0) {
            $user_detail = $user_detail[0];
        }
        return $user_detail;
    }

    public function getUserInfoByUserName($userName)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' where and username = ' . $this->_mysql->quote($userName);
        $detail = $this->_mysql->execute_query_to_array($qr);
        if (count($detail) > 0) {
            $detail = $detail[0];
        }
        return $detail;
    }

    public function getUserByParentId($parent_id)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' where status=1 and parent_id = ' . $this->_mysql->quote($parent_id);
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    public function getUser($page, $pageSize, $status = NULL)
    {
        $page = $this->_mysql->quote($page);
        if ($status == NULL) {
            $qr = 'SELECT * FROM ' . $this->_table . ' ORDER BY id DESC LIMIT ' . ($page - 1) * $pageSize . ',' . $pageSize;
        } else {
            $qr = 'SELECT * FROM ' . $this->_table . ' WHERE status =' . $status . ' ORDER BY id DESC LIMIT ' . ($page - 1) * $pageSize . ',' . $pageSize;
        }
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    public function getAllUserByCategoryId($categoryId, $page, $pageSize)
    {
        $page = $this->_mysql->quote($page);
        $qr = 'SELECT * FROM ' . $this->_table . ' WHERE status=1 and category_id = ' . $categoryId . ' LIMIT ' . ($page - 1) * $pageSize . ',' . $pageSize;
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    public function getTotalRecord($status = NULL)
    {
        if ($status == NULL) {
            $result = mysql_query("select count(id) as num_rows from " . $this->_table);
        } else {
            $result = mysql_query("select count(id) as num_rows from " . $this->_table . " WHERE status=1");
        }
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function addNewUser($params)
    {
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateUser($id, $params)
    {
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteUser($id)
    {
        return $this->_mysql->delete($this->_table, $id);
    }

    /* search */

    public function getTotalResult($key)
    {
        $result = mysql_query("select count(id) as num_rows from " . $this->_table . " where title like '%" . $key . "%'");
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function getSearchResults($key, $page, $pageSize)
    {
        $page = $this->_mysql->quote($page);
        $qr = 'SELECT * FROM ' . $this->_table . " where title like '%" . $key . "%' LIMIT " . ($page - 1) * $pageSize . ',' . $pageSize;
        $result = $this->_mysql->execute_query_to_array($qr);
        return $result;
    }

    /* end search */
}

?>
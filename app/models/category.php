<?php

/**
 * @author quyetnd
 */
Class categoryModel Extends baseModel
{

    private $_table = 'sf_category';

    public function getTableName()
    {
        return $this->_table;
    }

    public function getAllCategorys()
    {
        return $this->_mysql->select_all($this->_table);
    }

    public function getCategoryInfo($id)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' where id = ' . $this->_mysql->quote($id);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getCategoryInfoByKey($url_key)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' where url_key = ' . $this->_mysql->quote($url_key);
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        if (count($category_detail) > 0) {
            $category_detail = $category_detail[0];
        }
        return $category_detail;
    }

    public function getCategoryByParentId($parent_id)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' where parent_id = ' . $this->_mysql->quote($parent_id) . ' order by sort_order ASC';
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getByParentIdAndPost($parent_id, $post)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' cate INNER JOIN sf_category_position pos ON cate.id = pos.category_id where pos.position_id = ' . $this->_mysql->quote($post) . ' AND parent_id = ' . $this->_mysql->quote($parent_id) . ' order by sort_order ASC';
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getParentArtCate($parent_id)
    {
        $qr = "SELECT * FROM " . $this->_table . " where type in ('news','about') AND parent_id = " . $this->_mysql->quote($parent_id) . " order by sort_order ASC";
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getParentProCate($parent_id)
    {
        $qr = "SELECT * FROM " . $this->_table . " where type = 'product' AND parent_id = " . $this->_mysql->quote($parent_id) . " order by sort_order ASC";
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getCategoryByType($type)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' WHERE type = ' . $this->_mysql->quote($type) . ' order by sort_order ASC';
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getCateByTypePost($type, $post)
    {
        $qr = 'SELECT * FROM ' . $this->_table . ' cate INNER JOIN sf_category_position pos ON cate.id = pos.category_id WHERE pos.position_id = ' . $this->_mysql->quote($post) . ' AND cate.type = ' . $this->_mysql->quote($type) . ' order by cate.sort_order ASC';
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getCategorys($page, $pageSize)
    {
        $page = $this->_mysql->quote($page);
        $qr = 'SELECT * FROM ' . $this->_table . ' LIMIT ' . ($page - 1) * $pageSize . ',' . $page * $pageSize;
        $category_detail = $this->_mysql->execute_query_to_array($qr);
        return $category_detail;
    }

    public function getTotalRecord()
    {
        $result = mysql_query("select count(id) as num_rows from " . $this->_table);
        $row = mysql_fetch_object($result);
        $total = $row->num_rows;
        return $total;
    }

    public function addNewCategory($params)
    {
        return $this->_mysql->insert($this->_table, $params);
    }

    public function updateCategory($id, $params)
    {
        return $this->_mysql->update($this->_table, $id, $params);
    }

    public function deleteCategory($id)
    {
        return $this->_mysql->delete($this->_table, $id);
    }

}

?>
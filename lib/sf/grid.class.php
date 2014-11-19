<?php

/**
 * @author quyetnd
 */
class Grid
{

    public static $instance = NULL;
    private $html = '';
    private $_collection;
    private $_module;
    private $_controller;
    private $_id;
    private $_column = array();
    private $_totalRecord;
    private $_pageSize;
    private $_page;
    private $_numberPage;
    private $_totalPage;

    function __construct($collection)
    {
        $this->_collection = $collection;
        if (!isset($_id)) {
            $this->_id = 'id';
        }
        if (!isset($_totalRecord)) {
            $this->_totalRecord = 0;
        }
        if (!isset($_pageSize)) {
            $this->_pageSize = 10;
        }
        if (!isset($_numberPage)) {
            $this->_numberPage = 10;
        }
        if (!isset($_totalPage)) {
            $this->_totalPage = 0;
        }
    }

    public static function getInstance()
    {
        if (self::$instance === NULL) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function addColumn($attribute)
    {
        array_push($this->_column, $attribute);
    }

    public function setModule($name)
    {
        $this->_module = $name;
    }

    public function setController($name)
    {
        $this->_controller = $name;
    }

    public function setId($idColumnName)
    {
        $this->_id = $idColumnName;
    }

    public function setTotalRecord($totalRecord)
    {
        $this->_totalRecord = $totalRecord;
    }

    public function setPageSize($pageSize)
    {
        $this->_pageSize = $pageSize;
    }

    public function setPage($page)
    {
        $this->_page = $page;
    }

    public function setNumberPage($numberPage)
    {
        $this->_numberPage = $numberPage;
    }

    public function startPage()
    {
        if ($this->_page > $this->_totalPage) {
            return 1;
        }
        $midPost = round($this->_numberPage / 2);
        if ($this->_totalPage > $this->_numberPage) {
            if ($this->_page > $midPost) {
                if (($this->_page + ($this->_numberPage - $midPost)) > $this->_totalPage) {
                    $startPage = (int) ($this->_totalPage - $this->_numberPage);
                    return $startPage;
                } else {
                    $startPage = (int) ($this->_page - $midPost);
                    return $startPage;
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    public function html()
    {
        if (count($this->_collection) == 0) {
            return;
        }
        if (round($this->_totalRecord / $this->_pageSize) < $this->_totalRecord / $this->_pageSize) {
            $this->_totalPage = round($this->_totalRecord / $this->_pageSize) + 1;
        } else {
            $this->_totalPage = round($this->_totalRecord / $this->_pageSize);
        }
        $this->html = '<div class="div_total">Có ' . $this->_totalRecord . ' bản ghi ( ' . $this->_totalPage . ' trang ) được tìm thấy</div>';
        $this->html .= "<form action=\"/$this->_module/$this->_controller/delall/\" method=\"post\" name=\"frmGrid\" id=\"frmGrid\">";
        $this->html .= '<table class="tblList" cellspacing="0" cellpadding="0">';
        $this->html .= "<tr class=\"tr_head\">
                            <td width=\"30px\"><input type=\"checkbox\" name=\"chkAll\" onclick=\"checkAll(chkAll,document.frmGrid['chkItem[]']);\" value=\"Check All\" /></td>";
        foreach ($this->_column as $column) {
            if ($column['width'] != '') {
                $widthStr = "width=" . $column['width'] . "px";
            } else {
                $widthStr = '';
            }
            $this->html .= "<td " . $widthStr . ">" . $column['header'] . '</td>';
        }

        $this->html .= '<td width="30">Sửa</td>
                            <td width="30">Xóa</td>
                        </tr>';
        $i = 0;
        $this->html .= "<input type=\"hidden\" name=\"chkItem[]\" value=\"-1\" />";
        foreach ($this->_collection as $item) {
            $i++;
            $chan_le = $i % 2;
            $this->html .= "<tr class=\"tr_item_$chan_le\">
                                <td class=\"a_center\"><input type=\"checkbox\" name=\"chkItem[]\" value=\"" . $item["$this->_id"] . "\" /></td>";
            foreach ($this->_column as $column) {
                $this->html .= "<td class=\"a_" . $column['align'] . "\"><a href=\"/$this->_module/$this->_controller/edit/id/" . $item["$this->_id"] . "\">" . $item[$column["index"]] . "</a></td>";
            }
            $this->html .= "<td class=\"a_" . $column['align'] . "\"><a href=\"/$this->_module/$this->_controller/edit/id/" . $item["$this->_id"] . "\">Sửa</a></td>
                                <td class=\"a_" . $column["align"] . "\"><a href=\"/$this->_module/$this->_controller/delete/id/" . $item["$this->_id"] . "\">Xóa</a></td>               
                                </tr>";
        }
        $this->html .= "<tr><td colspan=\"100\" class=\"tdDelAll\"><input type=\"button\" name=\"cmdDeleteAll\" onclick=\"delAll(frmGrid,document.frmGrid['chkItem[]']);\" value=\"Xóa\" /></td></tr>";
        $this->html .= "<tr class=\"tr_footer\"><td colspan=\"100\">";
        $startPage = $this->startPage();
        $maxPage = $startPage;
        if ($startPage + $this->_numberPage > $this->_totalPage) {
            $maxPage = $this->_totalPage;
        } else {
            $maxPage = $startPage + $this->_numberPage;
        }
        if ($maxPage != 1) {
            if ($this->_page > 1) {
                $this->html .= "<a href=\"../page/" . ($this->_page - 1) . "\">Trước</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            } else {
                $this->html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
            for ($i = $startPage; $i < ($maxPage + 1); $i++) {
                if ($i != $this->_page) {
                    if (strpos($_SERVER['REQUEST_URI'], 'page')) {
                        $this->html .= "<a href=\"../page/" . $i . "\">" . $i . '</a>&nbsp;&nbsp;&nbsp;';
                    } else {
                        $this->html .= "<a href=\"" . $_SERVER['REQUEST_URI'] . "/page/" . $i . "\">" . $i . '</a>&nbsp;&nbsp;&nbsp;';
                    }
                } else {
                    $this->html .= $i . '&nbsp;&nbsp;&nbsp;';
                }
            }
            if ($this->_page < $maxPage) {
                if (strpos($_SERVER['REQUEST_URI'], 'page')) {
                    $this->html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"../page/" . ($this->_page + 1) . "\">Tiếp</a>";
                } else {
                    $this->html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"" . $_SERVER['REQUEST_URI'] . "/page/" . ($this->_page + 1) . "\">Tiếp</a>";
                }
            } else {
                $this->html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        }
        $this->html .= "</tr></td>";
        $this->html .= '</table>';
        $this->html .= '</form>';
        return $this->html;
    }

}

?>

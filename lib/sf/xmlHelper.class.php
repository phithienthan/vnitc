<?php

/**
 * @author quyetnd
 */
class XmlHelper
{

    private $source;
    private $mydate;
    
    public function __construct($url) {
        $this->source = $url;
    }
    
    function getXML()
    {
        $content = file_get_contents($this->source);
        $xmlData = NULL;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $content, $xmlData);
        xml_parser_free($p);
        $this->mydate = $xmlData['1']['value'];
        $data = array();
        if ($xmlData) {
            foreach ($xmlData as $v)
                if (isset($v['attributes'])) {
                    $data[] = $v['attributes'];
                }
            return $data;
        }
        return false;
    }
}

?>
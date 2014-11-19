<?php 
$file = 'a.txt';
$f = fopen($file,'a');
if (!$f) {
    echo 'can not open file';
} else {
    echo 'open file success';
}
fclose($f);
?>
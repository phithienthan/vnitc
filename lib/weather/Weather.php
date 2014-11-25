<?php
error_reporting(0);
$data = @file_get_contents('http://vnexpress.net/block/crawler?arrKeys%5B%5D=thoi_tiet');
$data = json_decode($data,true);


if(is_numeric($_GET['id']))
{
	$id = array(
		0 => 'tp_hcm',
		1 => 'son_la',
		2 => 'hai_phong',
		3 => 'ha_noi',
		4 => 'vinh',
		5 => 'da_nang',
		6 => 'nha_trang',
		7 => 'pleiku'
	);
	$id = $id[$_GET['id']];
}else{
	$id = isset($_GET['id'])?$_GET['id']:'tp_hcm';
}
$data  = $data['thoi_tiet'][$id];

$temp = $data['temp'];

?>
<table cellpadding="0" cellspacing="0" width="100%">
<tr><td>
<img src="http://st.f2.vnecdn.net/i/v2/weather/<?php echo $data['weather_code']; ?>.gif" align="left" />
<img src="images/<?php echo $temp[0]; ?>.gif" align="left" />
<img src="images/<?php echo $temp[1]; ?>.gif" align="left" />
<img src="images/c.gif" />
</td>
</tr>
<tr>
<td>
<?php echo $data['weather']; ?>
</td>
</tr>
</table>

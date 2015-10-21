<?php
include 'gis.php';
$start = microtime(true);
$gis = new gis();
$x = 2;#经纬度 116.40741300000002
$y = 2;#经纬度 39.904214
$level = 1;#1代表1千米，2代表2千米 3代表5千米 4代表1万米
$limit = '0,10';#需要的条数
$data = $gis->area($x,$y,$level,$limit);

//插入测试一百万条数据
//$gis->addTestdata();

#print_r($data);

$end = microtime(true);
echo $start;
echo '<hr />';
echo $end;
echo '<hr />';
echo $end - $start;
?>
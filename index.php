<?php
include 'gis.php';
$start = microtime(true);
$gis = new gis();
$x = 2;#经纬度 116.40741300000002
$y = 2;#经纬度 39.904214
$level = 1;#1代表1千米，2代表2千米 3代表5千米 4代表1万米
$limit = '0,1000000';#需要的条数
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

/**
 * 方法思路
 * 得到特定的点后，以这个点为中点，画一个菱形◇，然后使用MySQL空间数据库的算法，取出特定数据
 * 未增加索引前，遍历一百万条数据所需时间为2.5秒
 * 增加索引后，遍历一百万条数据所需时间为0.78704500198364秒
 * 
 */

?>
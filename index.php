<?php
include 'gis.php';
$start = microtime(true);
$gis = new gis();
$x = 2;#��γ�� 116.40741300000002
$y = 2;#��γ�� 39.904214
$level = 1;#1����1ǧ�ף�2����2ǧ�� 3����5ǧ�� 4����1����
$limit = '0,10';#��Ҫ������
$data = $gis->area($x,$y,$level,$limit);

//�������һ����������
//$gis->addTestdata();

#print_r($data);

$end = microtime(true);
echo $start;
echo '<hr />';
echo $end;
echo '<hr />';
echo $end - $start;
?>
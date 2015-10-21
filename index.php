<?php
include 'vendor/autoload.php';
include 'gis.php';


$gis = new gis();
$gis->addTestdata();

/* MBRContains(g1,g2)

����1��0��ָ��g1����С�߽�����Ƿ����g2����С�߽���Ρ�
mysql> SET @g1 = GeomFromText('Polygon((0 0,0 3,3 3,3 0,0 0))');
mysql> SET @g2 = GeomFromText('Point(1 1)');
mysql> SELECT MBRContains(@g1,@g2), MBRContains(@g2,@g1);
----------------------+----------------------+
| MBRContains(@g1,@g2) | MBRContains(@g2,@g1) |
+----------------------+----------------------+
|                    1 |                    0 |
+----------------------+----------------------+ */
?>
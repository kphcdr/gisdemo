<?php
/**
 * 计算特定距离内的点
 * @author kphcdr@163.com
 */
class gis 
{
	private $m;#数据库对象
	private $x;#当前精度116.40741300000002
	private $y;#当前维度39.904214
	public function __construct()
	{
		$this->m = new mysqli('127.0.0.1','root','root','geodatabase');
		if($this->m->connect_error ){
		    exit($this->m->connect_error);
		}
	}
	/**
	 * 获取区域内的数据
	 * @param 经度 float $x 116.40741300000002
	 * @param 维度 float $y 39.904214
	 * @param 距离等级 int $length
	 * @return array
	 */
	public function area($x,$y,$level=1,$limit='0,10')
	{
		$this->x = $x;
		$this->y = $y;
		$area = $this->getOrthogon($level);
		$areastr = "MBRContains(GeomFromText('Polygon((".$area['leftx']." ".$area['lefty'].",".$area['bomx']." ".$area['bomy'].",".$area['rightx']." ".$area['righty'].",".$area['topx']." ".$area['topy'].",".$area['leftx']." ".$area['lefty']."))')";
		$sql = "SELECT id,AsText(pnt) from test where $areastr ,GeomFromText(AsText(pnt))) LIMIT $limit";
		$result = $this->m->query($sql);
		$return = [];
		while($row = $result->fetch_assoc()) {
			$return[] = $row;
		}	
		return $return;
	}

	/**
	 * 获取给定地点的范围矩形
	 * @param 范围等级 int  $level 
	 * @return array
	 */
	private function getOrthogon($level = 1)
	{
		//根据等级，画一个矩形
		switch($level)
		{
			//1000米
			case 1:
				$area['topx'] = $this->x;
				$area['topy'] = $this->y + 0.01;
				$area['bomx'] = $this->x;
				$area['bomy'] = $this->y - 0.01;
				$area['leftx'] = $this->x - 0.01;
				$area['lefty'] = $this->y;
				$area['rightx'] = $this->x + 0.01;
				$area['righty'] = $this->y;
				break;
			//2000米
			case 2:
				$area['topx'] = $this->x;
				$area['topy'] = $this->y + 0.02;
				$area['bomx'] = $this->x;
				$area['bomy'] = $this->y - 0.02;
				$area['leftx'] = $this->x - 0.02;
				$area['lefty'] = $this->y;
				$area['rightx'] = $this->x + 0.02;
				$area['righty'] = $this->y;
				break;
			//5000米
			case 3:
				$area['topx'] = $this->x;
				$area['topy'] = $this->y + 0.05;
				$area['bomx'] = $this->x;
				$area['bomy'] = $this->y - 0.05;
				$area['leftx'] = $this->x - 0.05;
				$area['lefty'] = $this->y;
				$area['rightx'] = $this->x + 0.05;
				$area['righty'] = $this->y;
				break;
			//10000米
			case 4:
				$area['topx'] = $this->x;
				$area['topy'] = $this->y + 0.1;
				$area['bomx'] = $this->x;
				$area['bomy'] = $this->y - 0.1;
				$area['leftx'] = $this->x - 0.1;
				$area['lefty'] = $this->y;
				$area['rightx'] = $this->x + 0.1;
				$area['righty'] = $this->y;
				break;
			default :
				exit('There is no level');
		}
		return $area;
		/*
		 *每隔0.00001度，距离相差约1米；
		 *每隔0.0001度，距离相差约10米；
		 *每隔0.001度，距离相差约100米；
		 *每隔0.01度，距离相差约1000米；
		 *每隔0.1度，距离相差约10000米。
		 */
	}
	
	/**
	 * 增加测试数据
	 */
	public function addTestdata()
	{
		set_time_limit(0);
		$i = 0;
		while($i < 1000000)
		{
			$sql = "insert into test values(null,GeomFromText('POINT(".mt_rand(-100,100)." ".mt_rand(-100,100).")'));";
			$return = $this->m->query($sql);
			$i++;
		}
	}
}
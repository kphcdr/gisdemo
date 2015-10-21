<?php
function p($var)
{
	if (is_bool($var)) {
		var_dump($var);
	} else if (is_null($var)) {
		var_dump(NULL);
	} else {
		echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
	}
}

class gis 
{
	private $model;
	private $x;#当前精度116.40741300000002
	private $y;#当前维度39.904214
	public function __construct()
	{
		$this->m = new mysqli('127.0.0.1','root','root','geodatabase');
	}
	
	public function all()
	{
		$sql = 'select id,AsText(pnt) as p from test;';
		$result = $this->m->query($sql);
		$return = [];
		while($a = $result->fetch_assoc()) {
			$return[] = $a;
		}
			
	}
	
	/**
	 * 
	 * @param 经度  $this->x
	 * @param 维度  $this->y
	 * @param 距离 $length
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
		while($a = $result->fetch_assoc()) {
			$return[] = $a;
		}	
		p($return);
	}
/* 	
	*每隔0.00001度，距离相差约1米；
	*每隔0.0001度，距离相差约10米；
	*每隔0.001度，距离相差约100米；
	*每隔0.01度，距离相差约1000米；
	*每隔0.1度，距离相差约10000米。
 */
	public function getOrthogon($level)
	{
		//根据等级，画一个矩形
		switch($level)
		{
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
			case 5:
				$area['topx'] = $this->x;
				$area['topy'] = $this->y + 1;
				$area['bomx'] = $this->x;
				$area['bomy'] = $this->y - 1;
				$area['leftx'] = $this->x - 1;
				$area['lefty'] = $this->y;
				$area['rightx'] = $this->x + 1;
				$area['righty'] = $this->y;
				break;
		}
		return $area;		
	}
	
	public function addTestdata()
	{
		set_time_limit(0);
		$i = 0;
		while($i < 100000)
		{
			$sql = "insert into test values(null,GeomFromText('POINT(".mt_rand(-100,100)." ".mt_rand(-100,100).")'));";
			$return = $this->m->query($sql);
			$i++;
		}
	}
}
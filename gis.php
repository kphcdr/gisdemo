<?php
/**
 * �����ض������ڵĵ�
 * @author kphcdr@163.com
 */
class gis 
{
	private $m;#���ݿ����
	private $x;#��ǰ����116.40741300000002
	private $y;#��ǰά��39.904214
	public function __construct()
	{
		$this->m = new mysqli('127.0.0.1','root','root','geodatabase');
		if($this->m->connect_error ){
		    exit($this->m->connect_error);
		}
	}
	/**
	 * ��ȡ�����ڵ�����
	 * @param ���� float $x 116.40741300000002
	 * @param ά�� float $y 39.904214
	 * @param ����ȼ� int $length
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
	 * ��ȡ�����ص�ķ�Χ����
	 * @param ��Χ�ȼ� int  $level 
	 * @return array
	 */
	private function getOrthogon($level = 1)
	{
		//���ݵȼ�����һ������
		switch($level)
		{
			//1000��
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
			//2000��
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
			//5000��
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
			//10000��
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
		 *ÿ��0.00001�ȣ��������Լ1�ף�
		 *ÿ��0.0001�ȣ��������Լ10�ף�
		 *ÿ��0.001�ȣ��������Լ100�ף�
		 *ÿ��0.01�ȣ��������Լ1000�ף�
		 *ÿ��0.1�ȣ��������Լ10000�ס�
		 */
	}
	
	/**
	 * ���Ӳ�������
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
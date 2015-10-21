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
		
		
		p($return);
		
	}
	
}
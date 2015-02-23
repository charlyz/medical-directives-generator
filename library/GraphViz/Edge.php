<?php

class Edge
{
	var $from;
	var $to;
	var $name;
	
	public function Edge($from, $to, $name=null)
	{
		$this->from = $from;
		$this->to = $to;
		$this->name = $name;
	}
}

?>
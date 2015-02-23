<?php

class Model_Process_Edge
{
	public $from;
	public $to;
	public $name;
	public $duration_min;
	public $duratin_max;
	
	public function Model_Process_Edge(Model_Process_Node $from, Model_Process_Node $to, $name=null, $duration_min = null, $duration_max = null)
	{
		$this->from = $from;
		$this->to = $to;
		$this->name = $name;
		$this->duration_min = $duration_min;
		$this->duration_max = $duration_max;
	}

}

?>
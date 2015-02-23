<?php

class Model_Process_Blank implements Model_Process_Node 
{
	var $id;
	var $graph;
	var $shape = 'plaintext';
	var $name;
	var $url;
	var $color;
	
	public function Model_Process_Blank($id, Model_Process_Ghmsc $graph, $url=null, $color=null)
	{
		$this->name = 'Blank'.$id;
		$this->url = $url;
		$this->color = $color;
		$this->id = $id;
		$this->graph = $graph;
	}
	
	public function shape(){return $this->shape;}
	public function url(){return $this->url;}
	public function name(){return $this->name;}
	public function color(){return $this->color;}
	public function id(){return $this->id;}
	public function graph(){return $this->graph;}
}

?>
<?php

class Model_Process_Join implements Model_Process_Node 
{
	public $shape = 'plaintext';
	public $name;
	public $url;
	public $color;
	public $id;
	public $graph;
	
	public function Model_Process_Join($id, Model_Process_Ghmsc $graph, $url=null, $color=null)
	{
		$this->id = $id;
		$this->name = 'Join'.$id;
		$this->url = $url;
		$this->color = $color;
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
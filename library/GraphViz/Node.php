<?php

class Node
{
	var $name;
	var $url;
	var $shape;
	
	public function Node($name, $url=null, $shape=null)
	{
		$this->name = $name;
		$this->url = $url;
		$this->shape = $shape;
	}
}

?>
<?php

class Model_Agent_Decoration
{
	public $id;
	public $agent;
	public $decoration;
	public $type;
	
	public function Model_Agent_Decoration($id, Model_Agent_Entity $agent, $decoration, $type)
	{
		$this->id = $id;
		$this->agent = $agent;
		$this->decoration = $decoration;
		$this->type = $type;
	}
}
?>
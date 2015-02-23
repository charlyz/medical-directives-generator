<?php

class Model_Agent_Relation
{
	public $control_agent;
	public $monitor_agent;
	public $attribute;
	public $id;
	
	public function Model_Process_Edge($id, Model_Agent_Entity $control_agent, Model_Agent_Entity $monitor_agent, Model_Object_Attribute $attribute)
	{
		$this->id = $id;
		$this->control_agent = $control_agent;
		$this->monitor_agent = $monitor_agent;
		$this->attribute = $attribute;
	}

}

?>
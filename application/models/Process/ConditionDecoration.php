<?php

class Model_Process_ConditionDecoration
{
	public $id;
	public $condition;
	public $decoration;
	public $type;
	
	public function Model_Process_ConditionDecoration($id, Model_Process_Condition $condition, $decoration, $type)
	{
		$this->id = $id;
		$this->condition = $condition;
		$this->decoration = $decoration;
		$this->type = $type;
	}
}
?>
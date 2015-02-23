<?php

class Model_Process_TaskDecoration
{
	public $id;
	public $task;
	public $decoration;
	public $type;
	
	public function Model_Process_TaskDecoration($id, Model_Process_Task $task, $decoration, $type)
	{
		$this->id = $id;
		$this->task = $task;
		$this->decoration = $decoration;
		$this->type = $type;
	}
}
?>
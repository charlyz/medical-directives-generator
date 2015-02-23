<?php

class Model_Process_Condition
{
	public $id;
	public $node_decision;
	public $name;
	public $condition;
	public $node_target;
	private $decorations;
	
	public function Model_Process_Condition($id, Model_Process_Node $node_decision, $name, $condition, Model_Process_Node $node_target)
	{
		$this->id = $id;
		$this->node_decision = $node_decision;
		$this->name = $name;
		$this->condition = $condition;
		$this->node_target = $node_target;
	}
	
	public function decorations()
	{
		if($this->decorations!=null)
			return $this->decorations;
		
		$tConditionDeco = new Model_Db_ProcessesConditionsDecorations();
		$rowsCD = $tConditionDeco->fetchAll($tConditionDeco->select()->where('id_condition = ?', $this->id));
		$this->decorations = array();
		
		while(($rowCD = $rowsCD->current())!=null)
		{
			$type = $rowCD->findModel_Db_ProcessesConditionsDecorationsTypes()->current()->name;
			$cd = new Model_Process_ConditionDecoration($rowCD->id, $this, $rowCD->decoration, $type);
			$this->decorations[$type][] = $cd;
			$rowsCD->next();
		}
		return $this->decorations;
	}
}
?>
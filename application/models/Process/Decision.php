<?php

class Model_Process_Decision implements Model_Process_Node 
{
	public $id;
	public $shape = 'diamond';
	public $name;
	public $url;
	public $color;
	public $conditions;
	public $graph;
	
	public function Model_Process_Decision($id, Model_Process_Ghmsc $graph, $url=null, $color=null)
	{
		$this->id = $id;
		$this->name = 'Decision'.$id;
		$this->url = $url;
		$this->color = $color;
		$this->graph = $graph;
	}
	
	public function conditions()
	{
		if($this->conditions != null)
			return $this->condition;
		
		$this->conditions = array();
		$tPConditions = new Model_Db_ProcessesConditions();
		$rowsConditions = $tPConditions->fetchAll($tPConditions->_db->quoteInto('id_node = ?', $this->id));
		
		while(($rowCond = $rowsConditions->current())!=null)
		{
			$cond = new Condition();
			$cond->id = $rowCond->id;
			$cond->node_decision = $this;
			$cond->name = $rowCond->name;
			$cond->condition = $rowCond->condition;
			
			$tEdges = new Model_Db_ProcessesEdges();
			$id_node_target = $tEdges->find($rowCond->id_edge)->current()->id_node_to;
			$cond->node_target = $this->graph->getNodeFromId($id_node_target);
			
			$this->conditions[] = $cond;
			$rowsConditions->next();
		}
		return $this->condition;
	}
	
	public function shape(){return $this->shape;}
	public function url(){return $this->url;}
	public function name(){return ''/*$this->name*/;}
	public function color(){return $this->color;}
	public function id(){return $this->id;}
	public function graph(){return $this->graph;}
}

?>
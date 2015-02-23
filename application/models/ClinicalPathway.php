<?php

class Model_ClinicalPathway
{
	public $id;
	public $processes_model;
	public $agents_model;
	public $objects_model;
	
	public function Model_ClinicalPathway($id)
	{
		$this->id = $id;
		$this->loadProcessesModel();
		$this->loadObjectsModel();
		$this->loadAgentsModel();
	}
	
	public function loadProcessesModel()
	{
		$tGraphs = new Model_Db_ProcessesGraphs();
		$rowGraph = $tGraphs->fetchAll($tGraphs->select()->where('id_cp=?', $this->id)->where('id_node_parent IS NULL'))->current();
		$this->processes_model = new Model_Process_Ghmsc($rowGraph->id, $this, null);
	}
	
	public function loadAgentsModel()
	{
		$this->agents_model = new Model_Agent_Graph($this);
	}
	
	public function loadObjectsModel()
	{
		$this->objects_model = new Model_Object_Set($this);
	}
	
	public function getGhmscById($id, Model_Process_Ghmsc $ghmsc = null)
	{
		if($ghmsc == null)
			$ghmsc = $this->processes_model;
		
		if($ghmsc->id == $id)
			return $ghmsc;
		
		$nodes = $ghmsc->nodes;
		
		foreach($nodes as $node)
		{
			if($node instanceof Model_Process_Task)
			{
				if($node->isGhmsc())
				{
					$nextGhmsc = $node->under_graph;
					
					if($nextGhmsc->id == $id)
						return $nextGhmsc;
					$res = $this->getGhmscById($id, $nextGhmsc);
					
					if($res != null)
						return $res;
				}
			}
		}
		return null;
		
	}

}
?>
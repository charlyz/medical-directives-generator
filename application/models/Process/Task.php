<?php

class Model_Process_Task implements Model_Process_Node 
{
	public $shape = 'rectangle';
	public $name;
	public $url;
	public $color;
	public $precondition;
	public $definition;
	public $duration_min;
	public $duration_max;
	public $graph;
	public $under_graph;
	public $isGhmsc;
	public $id;
	public $decorations;
	public $agents;
	public $objects;
	
	public function Model_Process_Task($id, Model_Process_Ghmsc $graph, $url=null, $color=null)
	{
		$this->id = $id;
		$this->url = $url;
		$this->color = $color;
		$this->graph = $graph;
		
		$tTasks = new Model_Db_ProcessesTasks();
		//echo $id.' - '.$rowTask = $tTasks->fetchAll($tTasks->select()->where('id=?', '4'))->count().'<br>';
		$rowTask = $tTasks->fetchAll($tTasks->select()->where('id_node=?', $this->id))->current();
		$this->precondition = $rowTask->precondition;
		$this->definition = $rowTask->definition;
		$this->duration_min = $rowTask->duration_min;
		$this->duration_max = $rowTask->duration_max;
		
		$tNodes = new Model_Db_ProcessesNodes();
		$rowNode = $tNodes->fetchRow($tNodes->select()->where('id=?', $this->id));
		$this->name = $rowNode->name;
	}
	
	public function decorations()
	{
		if($this->decorations!=null)
			return $this->decorations;
		
		$tTaskDeco = new Model_Db_ProcessesTasksDecorations();
		$rowsTD = $tTaskDeco->fetchAll($tTaskDeco->select()->where('id_node = ?', $this->id));
		$this->decorations = array();
		
		while(($rowTD = $rowsTD->current())!=null)
		{
			$type = $rowTD->findModel_Db_ProcessesTasksDecorationsTypes()->current()->name;
			$td = new Model_Process_TaskDecoration($rowTD->id, $this, $rowTD->decoration, $type);
			$this->decorations[$rowTD->id] = $td;
			$rowsTD->next();
		}
		return $this->decorations;
	}
	
	public function getDecorationsFromDirectiveConfig(Model_Configuration_Directive $cD)
	{
		$decos = $this->decorations();
		$res  = array();
		foreach($cD->idsDecoration() as $id_decoration)
		{
			$res[$id_decoration] = $decos[$id_decoration];
		}
		return $res;
	}
	
	public function getTemplateMappingArray(Model_Configuration_Directive $aConf)
	{
		$res = array();
		$decos = $this->getDecorationsFromDirectiveConfig($aConf);
		$definition = $this->definition;
		$res['decoration'] = array();
		foreach($decos as $k=>$deco)
		{
			if($deco->type == 'definition')
			{
				$definition = $deco->decoration;
			}else
			{
				$res/*['decoration']*/[$deco->type] = $deco->decoration;
			}
		}
		
		$res['agent'] = array();
		foreach($this->getAgentsFromDirectiveConfig($aConf) as $agent)
		{
			$res['agent'][] = $agent->getTemplateMappingArray();
		}
		
		$res['objet'] = array();
		foreach($this->getObjectsFromDirectiveConfig($aConf) as $object)
		{
			$res['objet'][] = $object->getTemplateMappingArray();
		}
		
		$res['id'] = $this->id;
		$res['nom'] = $this->name;
		$res['definition'] = $definition;
		$res['duree_min'] = $this->duration_min/60;
		$res['duree_max'] = $this->duration_max/60;
		return $res;
	}
	
	public function agents()
	{
		if($this->agents!=null)
			return $this->agents;
		
		$t = new Model_Db_ProcessesTasksRelationsAgents();
		$rows = $t->fetchAll($t->select()->where('id_node = ?', $this->id));
		$this->agents = array();
		
		while(($row = $rows->current())!=null)
		{
			$agent = $this->graph->cp->agents_model->getAgentFromId($row->id_agent);
			$this->agents[$agent->name][] = $agent;
			$rows->next();
		}
		return $this->agents;
	}
	
	public function getAgentsFromDirectiveConfig(Model_Configuration_Directive $cD)
	{
		$agents = $this->agents();
		$res  = array();
		foreach($cD->idsAgents() as $id_agent)
		{
			$res[$id_agent] = $agents[$id_agent];
		}
		return $res;
	}
	
	public function objects()
	{
		if($this->objects!=null)
			return $this->objects;
		
		$t = new Model_Db_ProcessesTasksRelationsObjects();
		$rows = $t->fetchAll($t->select()->where('id_node = ?', $this->id));
		$this->objects = array();
		
		while(($row = $rows->current())!=null)
		{
			$object = $this->graph->cp->objects_model->getAgentFromId($row->id_object);
			$this->objects[$object->name][] = $object;
			$rows->next();
		}
		return $this->objects;
	}
	
	public function getObjectsFromDirectiveConfig(Model_Configuration_Directive $cD)
	{
		$obj = $this->objects();
		$res  = array();
		foreach($cD->idsObjects() as $id_object)
		{
			$res[$id_object] = $obj[$id_object];
		}
		return $res;
	}	
	
	public function isGhmsc()
	{
		if($this->isGhmsc!=null)
			return $this->isGhmsc;
		
		$tGraphs = new Model_Db_ProcessesGraphs();
		$rowsGraph = $tGraphs->fetchAll($tGraphs->select()->where('id_node_parent=?', $this->id));
		
		if($rowsGraph->count()<1)
		{
			$this->isGhmsc = false;
			return false;
		}

		$rowGraph = $rowsGraph->current();
		$this->under_graph = new Model_Process_Ghmsc($rowGraph->id, $this->graph->cp, $this);
		$this->isGhmsc = true;
		return true;
	}
	
	
	public function shape(){return $this->shape;}
	public function url(){return $this->url;}
	public function name(){return $this->name;}
	public function color(){return $this->color;}
	public function id(){return $this->id;}
	public function graph(){return $this->graph;}
}

?>
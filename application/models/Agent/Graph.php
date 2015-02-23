<?php

class Model_Agent_Graph
{
	public $agents;
	public $relations;
	public $cp;
	
	public function Model_Agent_Graph(Model_ClinicalPathway $cp)
	{
		$this->cp = $cp;
		$this->agents = array();
		$this->relations = array();
		$this->load();
	}
	
	public function addAgent(Model_Agent_Entity $agent)
	{
		$this->agents[$agent->name] = $agent;
	}
	
	public function addRelation(Model_Agent_Relation $relation)
	{
		$this->relations[$relation->id] = $relation;
	}
	
	public function removeRelation(Model_Agent_Relation $relation)
	{
		unset($this->relations[$relation->id]);
	}
	
	public function removeAgent(Model_Agent_Entity $agent)
	{
		unset($this->agents[$agent->name]);
		
		foreach($this->relations as $k=>$r)
		{
			if($r->control_agent->name == $agent->name || $r->monitor_agent->name == $agent->name)
			{
				unset($this->relations[$k]);
			}
		}
	}
	
	public function getAgentFromId($id)
	{
		foreach($this->agents as $a)
		{
			if($a->id == $id)
			{
				return $a;
			}
		}
		return null;
	}
	
	public function load()
	{
		$tAgents = new Model_Db_Agents();
		$rowsAgents = $tAgents->fetchAll($tAgents->select()->where('id_cp=?', $this->cp->id));
		
		while(($rowAgent = $rowsAgents->current())!=null)
		{
			$agent = new Model_Agent_Entity($rowAgent->id, $this);
			$this->addAgent($agent);	
			$rowsAgents->next();
		}
		
		foreach($this->agents as $control_agent)
		{
			$tRelations = new Model_Db_AgentsRelationsObjects();
			$rowsRelations = $tRelations->fetchAll($tRelations->select()->where('id_agent_control=?', $control_agent->id));

			while(($rowRelation = $rowsRelations->current())!=null)
			{
				$monitor_agent = $this->getAgentFromId($rowRelation->id_agent_monitor);
				$attribute = $this->cp->objects_model->getAttributeFromId($rowRelation->id_attribute);
				
				$relation = new Model_Agent_Relation($rowRelation->id, $control_agent, $monitor_agent, $attribute);
				$this->addRelation($relation);

				$rowsRelations->next();
			}
		}
		
	}
	
}
?>
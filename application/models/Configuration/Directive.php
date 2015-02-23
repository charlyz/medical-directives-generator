<?php

class Model_Configuration_Directive
{
	public $id_node;
	public $ids_decoration;
	public $ids_agents;
	public $ids_objects;
	
	public function Model_Configuration_Directive($id, Model_Configuration $config)
	{
		$this->id_node = $id;
		$this->config = $config;
	}
	
	public function idsDecoration()
	{
		if($this->ids_decoration!=null)
			return $this->ids_decoration;
		
		$db = Zend_Db_Table::getDefaultAdapter ();
		$rows = $db->query('SELECT 	c.id_decoration as id_decoration
							FROM 	configurations_nodes_tasks_decorations as c,
									processes_tasks_decorations as a
							WHERE 	c.id_decoration=a.id
									AND a.id_node='.$this->id_node.'
									AND c.id_config='.$this->config->id)->fetchAll();
		$this->ids_decoration = array();
		foreach ($rows as $row)
		{
			$this->ids_decoration[] = $row['id_decoration'];
		}
		
		return $this->ids_decoration;
	}
	
	public function idsAgents()
	{
		if($this->ids_agents!=null)
			return $this->ids_agents;
		
		$this->ids_agents = array();	
		$db = Zend_Db_Table::getDefaultAdapter ();
		$rows = $db->query('SELECT 	a.id_agent as id_agent
							FROM 	configurations_nodes_tasks_agents as c,
									processes_tasks_relations_agents as a
							WHERE 	c.id_relation=a.id
									AND a.id_node='.$this->id_node.'
									AND c.id_config='.$this->config->id)->fetchAll();
		
		foreach ($rows as $row)
		{
			$this->ids_agents[] = $row['id_agent'];
		}
		
		return $this->ids_agents;
	}
	
	public function idsObjects()
	{
		if($this->ids_objects!=null)
			return $this->ids_objects;
		
		$this->ids_objects = array();
		$db = Zend_Db_Table::getDefaultAdapter ();
		$rows = $db->query('SELECT 	a.id_object as id_object
							FROM 	configurations_nodes_tasks_objects as c,
									processes_tasks_relations_objects as a
							WHERE 	c.id_relation=a.id
									AND a.id_node='.$this->id_node.'
									AND c.id_config='.$this->config->id)->fetchAll();
		
		foreach ($rows as $row)
		{
			$this->ids_objects[] = $row['id_object'];
		}
		
		return $this->ids_objects;
	}
}
?>
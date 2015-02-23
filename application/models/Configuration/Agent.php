<?php

class Model_Configuration_Agent
{
	public $id_agent;
	public $config;
	public $ids_decoration;
	
	public function Model_Configuration_Agent($id, Model_Configuration $config)
	{
		$this->id_agent = $id;
		$this->config = $config;
	}
	
	public function idsDecoration()
	{
		if($this->ids_decoration!=null)
			return $this->ids_decoration;
		
		$db = Zend_Db_Table::getDefaultAdapter ();
		$rows = $db->query('SELECT 	c.id_decoration as id_decoration
							FROM 	configurations_agents_decorations as c,
									agents_decorations as a
							WHERE 	c.id_decoration=a.id
									AND a.id_agent='.$this->id_agent.'
									AND c.id_config='.$this->config->id)->fetchAll();
		$this->ids_decoration = array();
		foreach ($rows as $row)
		{
			$this->ids_decoration[] = $row['id_decoration'];
		}
		
		return $this->ids_decoration;
	}
}
?>
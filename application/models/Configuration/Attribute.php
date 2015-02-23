<?php

class Model_Configuration_Attribute
{
	public $id_attribute;
	public $ids_decoration;
	
	public function Model_Configuration_Attribute($id, Model_Configuration $config)
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
							FROM 	configurations_objects_attributes_decorations as c,
									objects_attributes_decorations as a
							WHERE 	c.id_decoration=a.id
									AND a.id_attribute='.$this->id_attribute.'
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
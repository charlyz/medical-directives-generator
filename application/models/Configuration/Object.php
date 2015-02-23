<?php

class Model_Configuration_Object
{
	public $id_object;
	public $ids_decoration;
	public $attributes;
	
	public function Model_Configuration_Object($id, Model_Configuration $config)
	{
		$this->id_object = $id;
		$this->attributes = array();
		$this->config = $config;
	}
	
	public function addAttribute(Model_Configuration_Attribute $att)
	{
		$this->attributes[$att->id_attribute] = $att;
	}
	
	public function idsDecoration()
	{
		if($this->ids_decoration!=null)
			return $this->ids_decoration;
		
		$db = Zend_Db_Table::getDefaultAdapter ();
		$rows = $db->query('SELECT 	c.id_decoration as id_decoration
							FROM 	configurations_objects_decorations as c,
									objects_decorations as a
							WHERE 	c.id_decoration=a.id
									AND a.id_object='.$this->id_object.'
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
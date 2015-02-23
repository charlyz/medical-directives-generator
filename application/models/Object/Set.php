<?php

class Model_Object_Set
{
	public $objects;
	public $cp;
	
	public function Model_Object_Set(Model_ClinicalPathway $cp)
	{
		$this->cp = $cp;
		$this->objects = array();
		$this->load();
	}
	
	public function addObject(Model_Object_Entity $object)
	{
		$this->objects[$object->name] = $object;
	}
	
	public function getAttributeFromId($id)
	{
		foreach($this->objects as $o)
		{
			if(($att = $o->getAttributeFromId($id)) != null)
			{
				return $att;
			}
		}
		return null;
	}
	
	public function removeObject(Model_Object_Entity $object)
	{
		unset($this->objects[$object->name]);
		
		foreach($this->cp->agents_model->relations as $k=>$r)
		{
			if($r->attribute->object->name == $object->name)
			{
				unset($this->cp->agents_model->relations[$k]);
			}
		}
	}
	
	public function removeAttribute(Model_Object_Attribute $att)
	{
		unset($att->object->attributes[$att->name]);
		
		foreach($this->cp->agents_model->relations as $k=>$r)
		{
			if($r->attribute->name == $att->name)
			{
				unset($this->cp->agents_model->relations[$k]);
			}
		}
	}
	
	public function getObjectFromId($id)
	{
		foreach($this->objects as $o)
		{
			if($o->id == $id)
			{
				return $o;
			}
		}
		return null;
	}
	
	public function load()
	{
		$tObjects = new Model_Db_Objects();
		$rowsObjects = $tObjects->fetchAll($tObjects->select()->where('id_cp=?', $this->cp->id));
		
		while(($rowObject = $rowsObjects->current())!=null)
		{
			$object = new Model_Object_Entity($rowObject->id, $this);
			$this->addObject($object);	
			$rowsObjects->next();
		}
	}
}

?>
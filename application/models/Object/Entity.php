<?php

class Model_Object_Entity
{
	public $id;
	public $name;
	public $definition;
	public $decorations;
	public $set;
	public $attributes;
	
	public function Model_Object_Entity($id, Model_Object_Set $set)
	{
		$this->set = $set;
		$this->id = $id;
		$tObjects = new Model_Db_Objects();
		$rowObject = $tObjects->fetchAll($tObjects->select()->where('id=?', $this->id))->current();
		$this->name = $rowObject->name;
		$this->definition = $rowObject->definition;
	}
	
	public function addAttribute(Model_Object_Attribute $att)
	{
		$this->attributes[$att->id] = $att;
	}
	
	public function getAttributeFromId($id)
	{
		foreach($this->attributes() as $a)
		{
			if($a->id == $id)
			{
				return $a;
			}
		}
		return null;
	}
	
	public function attributes()
	{
		if($this->attributes!=null)
			return $this->attributes;
		
		$tAtts = new Model_Db_ObjectsAttributes();
		$rowsAtts = $tAtts->fetchAll($tAtts->select()->where('id_object = ?', $this->id));
		$this->attributes = array();
		
		while(($rowAtt = $rowsAtts->current())!=null)
		{
			$att = new Model_Object_Attribute($rowAtt->id, $this);
			$this->addAttribute($att);
			$rowsAtts->next();
		}
		return $this->attributes;
	}
	
	public function decorations()
	{
		if($this->decorations!=null)
			return $this->decorations;
		
		$tObjectDeco = new Model_Db_ObjectsDecorations();
		$rowsOD = $tObjectDeco->fetchAll($tObjectDeco->select()->where('id_object = ?', $this->id));
		$this->decorations = array();
		
		while(($rowOD = $rowsOD->current())!=null)
		{
			$type = $rowOD->findModel_Db_ObjectsDecorationsTypes()->current()->name;
			$od = new Model_Object_Decoration($rowOD->id, $this, $rowOD->decoration, $type);

			$this->decorations[$rowOD->id] = $od;
			
			$rowsOD->next();
		}
		
		return $this->decorations;
	}
	
	public function getDecorationsFromObjectConfig(Model_Configuration_Object $cObj)
	{
		$decos = $this->decorations();
		$res  = array();
		foreach($cObj->idsDecoration() as $id_decoration)
		{
			$res[$id_decoration] = $decos[$id_decoration];
		}
		return $res;
	}
	
	public function getAttributesFromObjectConfig(Model_Configuration_Object $cObj)
	{
		$att = $this->attributes();
		$res  = array();
		foreach($cObj->attributes as $cAtt)
		{
			$res[$cAtt->id_attribute] = $att[$cAtt->id_attribute];
		}
		return $res;
	}
	
	public function getTemplateMappingArray(Model_Configuration_Object $conf)
	{
		$res = array();
		$decos = $this->getDecorationsFromObjectConfig($conf);
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
		
		$res['id'] = $this->id;
		$res['nom'] = $this->name;
		$res['definition'] = $definition;
		
		$res['attribut'] = array();
		
		foreach($this->getAttributesFromObjectConfig($conf) as $att)
		{
			$res['attribut'][] = $att->getTemplateMappingArray();
		}
		
		
		return $res;
	}
}
?>
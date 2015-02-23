<?php

class Model_Object_Attribute
{
	public $id;
	public $name;
	public $definition;
	public $decorations;
	public $object;
	
	public function Model_Object_Attribute($id, Model_Object_Entity $object)
	{
		$this->object = $object;
		$this->id = $id;
		$tAttributes = new Model_Db_ObjectsAttributes();
		$rowAttribute = $tAttributes->fetchAll($tAttributes->select()->where('id=?', $this->id))->current();
		$this->name = $rowAttribute->name;
		$this->definition = $rowAttribute->definition;
	}
	
	public function decorations()
	{
		if($this->decorations!=null)
			return $this->decorations;
		
		$tAttributesDeco = new Model_Db_ObjectsAttributesDecorations();
		$rowsAD = $tAttributesDeco->fetchAll($tAttributesDeco->select()->where('id_attribute = ?', $this->id));
		$this->decorations = array();
		
		while(($rowAD = $rowsAD->current())!=null)
		{
			$type = $rowAD->findModel_Db_ObjectsAttributesDecorationsTypes()->current()->name;
			$ad = new Model_Object_Decoration($rowAD->id, $this, $rowAD->decoration, $type);
			$this->decorations[$type][] = $ad;
			$rowsAD->next();
		}
		return $this->decorations;
	}
	
	public function getDecorationsFromAttributeConfig(Model_Configuration_Attribute $conf)
	{
		$decos = $this->decorations();
		$res  = array();
		foreach($conf->idsDecoration() as $id_decoration)
		{
			$res[$id_decoration] = $decos[$id_decoration];
		}
		return $res;
	}
	
	public function getTemplateMappingArray(Model_Configuration_Attribute $conf)
	{
		$res = array();
		$decos = $this->getDecorationsFromAttributeConfig($conf);
		$definition = $this->definition;
		$res['decorations'] = array();
		foreach($decos as $k=>$deco)
		{
			if($deco->type == 'definition')
			{
				$definition = $deco->decoration;
			}else
			{
				$res['decorations'][$deco->type] = $deco->decoration;
			}
		}
		
		$res['id'] = $this->id;
		$res['definition'] = $definition;
		$res['name'] = $this->name;
		return $res;
	}
}
?>
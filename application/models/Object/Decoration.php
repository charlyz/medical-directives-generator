<?php

class Model_Object_Decoration
{
	public $id;
	public $object;
	public $decoration;
	public $type;
	
	public function Model_Object_Decoration($id, Model_Object_Entity $object, $decoration, $type)
	{
		$this->id = $id;
		$this->object = $object;
		$this->decoration = $decoration;
		$this->type = $type;
	}
}
?>
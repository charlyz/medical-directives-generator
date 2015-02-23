<?php

class Model_Object_AttributeDecoration
{
	public $id;
	public $attribute;
	public $decoration;
	public $type;
	
	public function Model_Object_AttributeDecoration($id, Model_Object_Attribute $attribute, $decoration, $type)
	{
		$this->id = $id;
		$this->attribute = $attribute;
		$this->decoration = $decoration;
		$this->type = $type;
	}
}
?>
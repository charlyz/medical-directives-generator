<?php

class Model_Db_ObjectsAttributesDecorationsTypes extends Zend_Db_Table
{
	protected $_name = 'objects_attributes_decorations_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ObjectsAttributesDecorations');
	
    
}

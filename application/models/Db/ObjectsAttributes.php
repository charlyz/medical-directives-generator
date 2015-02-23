<?php

class Model_Db_ObjectsAttributes extends Zend_Db_Table
{
	protected $_name = 'objects_attributes';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ObjectsAttributesDecorations', 'Model_Db_ConfigurationsObjectsAttributes');
	
	protected $_referenceMap = array (
								'Object' => array (
											'columns' => 'id_object', 
											'refTableClass' => 'Model_Db_Objects',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

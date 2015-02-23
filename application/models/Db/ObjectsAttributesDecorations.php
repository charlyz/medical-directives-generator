<?php

class Model_Db_ObjectsAttributesDecorations extends Zend_Db_Table
{
	protected $_name = 'objects_attributes_decorations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsObjectsAttributesDecorations');
	
	protected $_referenceMap = array (
								'Attribute' => array (
											'columns' => 'id_attribute', 
											'refTableClass' => 'Model_Db_ObjectsAttributes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_ObjectsAttributesDecorationsTypes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

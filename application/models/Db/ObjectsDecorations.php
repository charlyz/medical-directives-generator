<?php

class Model_Db_ObjectsDecorations extends Zend_Db_Table
{
	protected $_name = 'objects_decorations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsObjectsDecorations');
	
	protected $_referenceMap = array (
								'Object' => array (
											'columns' => 'id_object', 
											'refTableClass' => 'Model_Db_Objects',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_ObjectsDecorationsTypes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

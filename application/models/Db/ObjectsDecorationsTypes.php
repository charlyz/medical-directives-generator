<?php

class Model_Db_ObjectsDecorationsTypes extends Zend_Db_Table
{
	protected $_name = 'objects_decorations_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ObjectsDecorations');
	
    	protected $_referenceMap = array (
								'Type' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ObjectsDecorations',
			           						'refColumns'        => 'id_type',
			            					'onDelete'          => self::CASCADE ));
}

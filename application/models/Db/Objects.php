<?php

class Model_Db_Objects extends Zend_Db_Table
{
	protected $_name = 'objects';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ObjectsDecorations', 
										'Model_Db_ObjectsAttributes', 
										'Model_Db_ConfigurationsObjects',
										'Model_Db_ProcessesTasksRelationsObjects');
	
	protected $_referenceMap = array (
								'CP' => array (
											'columns' => 'id_cp', 
											'refTableClass' => 'Model_Db_ClinicPathways',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

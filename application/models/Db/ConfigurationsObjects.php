<?php

class Model_Db_ConfigurationsObjects extends Zend_Db_Table
{
	protected $_name = 'configurations_objects';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Object' => array (
											'columns' => 'id_object', 
											'refTableClass' => 'Model_Db_Objects',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

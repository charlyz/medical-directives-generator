<?php

class Model_Db_ConfigurationsObjectsAttributes extends Zend_Db_Table
{
	protected $_name = 'configurations_objects_attributes';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Attribute' => array (
											'columns' => 'id_attribute', 
											'refTableClass' => 'Model_Db_ObjectsAttributes',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

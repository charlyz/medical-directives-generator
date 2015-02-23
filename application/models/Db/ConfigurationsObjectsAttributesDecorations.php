<?php

class Model_Db_ConfigurationsObjectsAttributesDecorations extends Zend_Db_Table
{
	protected $_name = 'configurations_objects_attributes_decorations';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Decoration' => array (
											'columns' => 'id_decoration', 
											'refTableClass' => 'Model_Db_ObjectsAttributesDecorations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

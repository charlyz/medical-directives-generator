<?php

class Model_Db_ConfigurationsObjectsDecorations extends Zend_Db_Table
{
	protected $_name = 'configurations_objects_decorations';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Decoration' => array (
											'columns' => 'id_decoration', 
											'refTableClass' => 'Model_Db_ObjectsDecorations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

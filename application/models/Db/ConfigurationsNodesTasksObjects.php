<?php

class Model_Db_ConfigurationsNodesTasksObjects extends Zend_Db_Table
{
	protected $_name = 'configurations_nodes_tasks_objects';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Relation' => array (
											'columns' => 'id_relation', 
											'refTableClass' => 'Model_Db_ProcessesTasksRelationsObjects',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

<?php

class Model_Db_ProcessesTasksRelationsObjects extends Zend_Db_Table
{
	protected $_name = 'processes_tasks_relations_objects';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesTasksObjects');
	
	protected $_referenceMap = array (
								'Task' => array (
											'columns' => 'id_task', 
											'refTableClass' => 'Model_Db_ProcessesTasks',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Object' => array (
											'columns' => 'id_object', 
											'refTableClass' => 'Model_Db_Objects',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

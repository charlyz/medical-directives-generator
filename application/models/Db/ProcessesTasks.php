<?php

class Model_Db_ProcessesTasks extends Zend_Db_Table
{
	protected $_name = 'processes_tasks';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesTasks', 'Model_Db_ProcessesTasksDecorations', 'Model_Db_ProcessesTasksRelationsAgents', 'Model_Db_ProcessesTasksRelationsObjects');
	
	protected $_referenceMap = array (
								'Node' => array (
											'columns' => 'id_node', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

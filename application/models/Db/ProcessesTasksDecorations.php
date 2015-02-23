<?php

class Model_Db_ProcessesTasksDecorations extends Zend_Db_Table
{
	protected $_name = 'processes_tasks_decorations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesTasksDecorations');
	
	protected $_referenceMap = array (
								'Task' => array (
											'columns' => 'id_task', 
											'refTableClass' => 'Model_Db_ProcessesTasks',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_ProcessesTasksDecorationsTypes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

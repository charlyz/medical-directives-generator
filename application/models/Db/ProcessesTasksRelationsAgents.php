<?php

class Model_Db_ProcessesTasksRelationsAgents extends Zend_Db_Table
{
	protected $_name = 'processes_tasks_relations_agents';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesTasksAgents');
	
	protected $_referenceMap = array (
								'Task' => array (
											'columns' => 'id_task', 
											'refTableClass' => 'Model_Db_ProcessesTasks',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Agent' => array (
											'columns' => 'id_agent', 
											'refTableClass' => 'Model_Db_Agents',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

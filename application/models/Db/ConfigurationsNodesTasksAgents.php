<?php

class Model_Db_ConfigurationsNodesTasksAgents extends Zend_Db_Table
{
	protected $_name = 'configurations_nodes_tasks_agents';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Relation' => array (
											'columns' => 'id_relation', 
											'refTableClass' => 'Model_Db_ProcessesTasksRelationsAgents',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

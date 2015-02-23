<?php

class Model_Db_AgentsRelationsObjects extends Zend_Db_Table
{
	protected $_name = 'agents_relations_objects';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'AgentControl' => array (
											'columns' => 'id_agent_control', 
											'refTableClass' => 'Model_Db_Agents',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'AgentMonitor' => array (
											'columns' => 'id_agent_monitor', 
											'refTableClass' => 'Model_Db_Agents',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Objet' => array (
											'columns' => 'id_attribute', 
											'refTableClass' => 'Model_Db_ObjectsAttributes',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

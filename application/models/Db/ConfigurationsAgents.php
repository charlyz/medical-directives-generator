<?php

class Model_Db_ConfigurationsAgents extends Zend_Db_Table
{
	protected $_name = 'configurations_agents';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Agent' => array (
											'columns' => 'id_agent', 
											'refTableClass' => 'Model_Db_Agents',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

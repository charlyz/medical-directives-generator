<?php

class Model_Db_Agents extends Zend_Db_Table
{
	protected $_name = 'agents';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_AgentsDecorations', 
										'Model_Db_AgentsRelationsObjects', 
										'Model_Db_ConfigurationsAgents',
										'Model_Db_ProcessesTasksRelationsAgents');
	
	protected $_referenceMap = array (
								'CP' => array (
											'columns' => 'id_cp', 
											'refTableClass' => 'Model_Db_ClinicPathways',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

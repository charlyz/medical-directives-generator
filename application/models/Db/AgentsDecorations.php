<?php

class Model_Db_AgentsDecorations extends Zend_Db_Table
{
	protected $_name = 'agents_decorations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsAgentsDecorations');
	
	protected $_referenceMap = array (
								'Agent' => array (
											'columns' => 'id_agent', 
											'refTableClass' => 'Model_Db_Agents',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_AgentsDecorationsTypes',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

<?php

class Model_Db_ProcessesConditions extends Zend_Db_Table
{
	protected $_name = 'processes_conditions';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesConditions');
	
	protected $_referenceMap = array (
								'Node' => array (
											'columns' => 'id_node', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Edge' => array (
											'columns' => 'id_edge', 
											'refTableClass' => 'Model_Db_ProcessesEdges',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

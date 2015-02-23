<?php

class Model_Db_ProcessesGraphs extends Zend_Db_Table
{
	protected $_name = 'processes_graphs';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ProcessesNodes');
	
	protected $_referenceMap = array (
								'NodeParent' => array (
											'columns' => 'id_node_parent', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'CP' => array (
											'columns' => 'id_cp', 
											'refTableClass' => 'Model_Db_ClinicPathways',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

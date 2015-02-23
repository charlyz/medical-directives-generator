<?php

class Model_Db_ProcessesNodes extends Zend_Db_Table
{
	protected $_name = 'processes_nodes';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ProcessesConditions');
	
	protected $_referenceMap = array (
								'Graph' => array (
											'columns' => 'id_graph', 
											'refTableClass' => 'Model_Db_ProcessesGraphs',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_ProcessesTypes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

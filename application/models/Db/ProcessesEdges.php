<?php

class Model_Db_ProcessesEdges extends Zend_Db_Table
{
	protected $_name = 'processes_edges';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Condition' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ProcessesConditions',
			           						'refColumns'        => 'id_edge',
			            					'onDelete'          => self::CASCADE ),
								'NodeFrom' => array (
											'columns' => 'id_node_from', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'NodeTo' => array (
											'columns' => 'id_node_to', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

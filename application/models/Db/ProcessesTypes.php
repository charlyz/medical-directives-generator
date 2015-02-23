<?php

class Model_Db_ProcessesTypes extends Zend_Db_Table
{
	protected $_name = 'processes_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ProcessesNodes');

	protected $_referenceMap = array (
								'Node' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ProcessesNodes',
			           						'refColumns'        => 'id_type',
			            					'onDelete'          => self::CASCADE ));
}

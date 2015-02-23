<?php

class Model_Db_ProcessesTasksDecorationsTypes extends Zend_Db_Table
{
	protected $_name = 'processes_tasks_decorations_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ProcessesTasksDecorations');
	protected $_referenceMap = array (
								'Type' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ProcessesTasksDecorations',
			           						'refColumns'        => 'id_type',
			            					'onDelete'          => self::CASCADE ));
    
}

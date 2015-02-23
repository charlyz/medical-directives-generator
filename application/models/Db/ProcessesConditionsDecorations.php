<?php

class Model_Db_ProcessesConditionsDecorations extends Zend_Db_Table
{
	protected $_name = 'processes_conditions_decorations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsNodesConditionsDecorations');
	
	protected $_referenceMap = array (
								'Condition' => array (
											'columns' => 'id_task', 
											'refTableClass' => 'Model_Db_ProcessesConditions',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_decoration', 
											'refTableClass' => 'Model_Db_ProcessesConditionsDecorationsTypes',
			           						'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

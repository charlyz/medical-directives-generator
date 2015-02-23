<?php

class Model_Db_ConfigurationsNodesConditions extends Zend_Db_Table
{
	protected $_name = 'configurations_nodes_conditions';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Condition' => array (
											'columns' => 'id_condition', 
											'refTableClass' => 'Model_Db_ProcessesConditions',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

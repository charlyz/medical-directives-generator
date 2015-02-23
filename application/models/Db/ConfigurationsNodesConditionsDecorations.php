<?php

class Model_Db_ConfigurationsNodesConditionsDecorations extends Zend_Db_Table
{
	protected $_name = 'configurations_nodes_conditions_decorations';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Decoration' => array (
											'columns' => 'id_condition', 
											'refTableClass' => 'Model_Db_ProcessesTasksDecorations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

<?php

class Model_Db_ConfigurationsNodesTasks extends Zend_Db_Table
{
	protected $_name = 'configurations_nodes_tasks';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_config', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Task' => array (
											'columns' => 'id_task', 
											'refTableClass' => 'Model_Db_ProcessesTasks',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

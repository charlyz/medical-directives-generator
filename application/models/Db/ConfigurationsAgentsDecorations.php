<?php

class Model_Db_ConfigurationsAgentsDecorations extends Zend_Db_Table
{
	protected $_name = 'configurations_agents_decorations';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_agent', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Decoration' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_AgentsDecorations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

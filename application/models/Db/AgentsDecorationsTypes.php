<?php

class Model_Db_AgentsDecorationsTypes extends Zend_Db_Table
{
	protected $_name = 'agents_decorations_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_AgentsDecorations');
	protected $_referenceMap = array (
								'Type' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_AgentsDecorations',
			            					'refColumns'        => 'id_type',
			            					'onDelete'          => self::CASCADE ));
    
}

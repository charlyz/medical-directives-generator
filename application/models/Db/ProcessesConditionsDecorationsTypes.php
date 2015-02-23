<?php

class Model_Db_ProcessesConditionsDecorationsTypes extends Zend_Db_Table
{
	protected $_name = 'processe_conditions_decorations_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ProcessesConditionsDecorations');
	
    
}

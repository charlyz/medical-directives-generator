<?php

class Model_Db_ConfigurationsReportsObjects extends Zend_Db_Table
{
	protected $_name = 'configurations_reports_objects';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Order' => array (
											'columns' => 'id_order', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsOrder',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

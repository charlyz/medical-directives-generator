<?php

class Model_Db_ConfigurationsReports extends Zend_Db_Table
{
	protected $_name = 'configurations_reports';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsReportsOrder');
	
	protected $_referenceMap = array (
								'Configuration' => array (
											'columns' => 'id_configuration', 
											'refTableClass' => 'Model_Db_Configurations',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

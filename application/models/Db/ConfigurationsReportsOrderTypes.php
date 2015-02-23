<?php

class Model_Db_ConfigurationsReportsOrderTypes extends Zend_Db_Table
{
	protected $_name = 'configurations_reports_order_types';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsReportsOrder');
	
    
}

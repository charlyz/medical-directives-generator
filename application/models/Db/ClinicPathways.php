<?php

class Model_Db_ClinicPathways extends Zend_Db_Table
{
	protected $_name = 'clinic_pathways';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_Agents',
										'Model_Db_Configurations',
										'Model_Db_Objects',
										'Model_Db_ProcessesGraphs');
	
    
}

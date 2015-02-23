<?php

class Model_Db_Configurations extends Zend_Db_Table
{
	protected $_name = 'configurations';
	protected $_primary = 'id';
	
	protected $_dependentTables = array('Model_Db_ConfigurationsAgents',
										'Model_Db_ConfigurationsAgentsDecorations',
										'Model_Db_ConfigurationsNodesDecisions',
										'Model_Db_ConfigurationsNodesTasks',
										'Model_Db_ConfigurationsNodesTasksDecorations',
										'Model_Db_ConfigurationsObjects',
										'Model_Db_ConfigurationsObjectsAttributes',
										'Model_Db_ConfigurationObjectsAttributesDecorations',
										'Model_Db_ConfigurationsObjectsDecorations',
										'Model_Db_ConfigurationsReports');
	
	protected $_referenceMap = array (
								'CP' => array (
											'columns' => 'id_cp', 
											'refTableClass' => 'Model_Db_ClinicPathways',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ));
    
}

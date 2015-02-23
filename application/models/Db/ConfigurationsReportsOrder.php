<?php

class Model_Db_ConfigurationsReportsOrder extends Zend_Db_Table
{
	protected $_name = 'configurations_reports_order';
	protected $_primary = 'id';
	
	protected $_referenceMap = array (
								'Report' => array (
											'columns' => 'id_report', 
											'refTableClass' => 'Model_Db_ConfigurationsReports',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Type' => array (
											'columns' => 'id_type', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsOrderTypes',
			            					'refColumns'        => 'id',
			            					'onDelete'          => self::CASCADE ),
								'Agent' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsAgents',
			            					'refColumns'        => 'id_order',
			            					'onDelete'          => self::CASCADE ),
								'Directive' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsDirectives',
			            					'refColumns'        => 'id_order',
			            					'onDelete'          => self::CASCADE ),
								'Object' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsObjects',
			            					'refColumns'        => 'id_order',
			            					'onDelete'          => self::CASCADE ),
								'Paragraph' => array (
											'columns' => 'id', 
											'refTableClass' => 'Model_Db_ConfigurationsReportsParagraphs',
			            					'refColumns'        => 'id_order',
			            					'onDelete'          => self::CASCADE ),);
    
}

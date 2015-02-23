<?php

class Model_Configuration_Report
{
	public $id;
	public $name;
	public $config;
	public $paragraphs;
	public $showContents;
	public $template;
	
	public function Model_Configuration_Report($id, Model_Configuration $config)
	{
		$this->id = $id;
		$this->config = $config;
		$this->paragraphs = array();
		
		$t = new Model_Db_ConfigurationsReports();
		$rowNode = $t->fetchRow($t->select()->where('id=?', $this->id));
		$this->name = $rowNode->name;
		$this->showContents = $rowNode->showContents;
		$this->template = $rowNode->template;
	}
	
	public function addParagraph(Model_Configuration_InterfaceParagraph $para)
	{
		$this->paragraphs[$para->order()] = $para;
	}
}
?>
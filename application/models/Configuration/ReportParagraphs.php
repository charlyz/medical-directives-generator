<?php

class Model_Configuration_ReportParagraphs implements Model_Configuration_InterfaceParagraph
{
	public $report;
	public $title;
	public $layout;
	public $order;
	public $content;
	public $name;
	
	public function Model_Configuration_ReportParagraphs($title, $layout, $order, $content, $name, Model_Configuration_Report $report)
	{
		$this->title = $title;
		$this->layout = $layout;
		$this->order = $order;
		$this->report = $report;
		$this->content = $content;
		$this->name = $name;
	}
	public function layout(){return $this->layout;}
	public function title(){return $this->title;}
	public function render()
	{
		
	}
	
	public function order()
	{
		return $this->order;
	}

}
?>
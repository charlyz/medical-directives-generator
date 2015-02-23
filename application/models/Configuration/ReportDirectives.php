<?php

class Model_Configuration_ReportDirectives implements Model_Configuration_InterfaceParagraph
{
	public $report;
	public $title;
	public $layout;
	public $order;
	
	public function Model_Configuration_ReportDirectives($title, $layout, $order, Model_Configuration_Report $report)
	{
		$this->title = $title;
		$this->layout = $layout;
		$this->order = $order;
		$this->report = $report;
	}
	
	public function render()
	{
		
	}
	public function layout(){return $this->layout;}
	public function title(){return $this->title;}
	public function order()
	{
		return $this->order;
	}

}
?>
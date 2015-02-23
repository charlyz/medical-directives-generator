<?php

class Model_Configuration
{
	public $agents;
	public $objects;
	public $report;
	public $directives;
	public $id;
	public $name;

	public function Model_Configuration($id, $id_report)
	{
		$this->agents = array();
		$this->id = $id;
		$this->loadReport($id_report);
		$this->loadAgents();
		$this->loadObjects();
		$this->directives = $this->loadDirectives();
		
				
	}
	
	public function loadObjects()
	{
		$t = new Model_Db_ConfigurationsObjects();
		$rows = $t->fetchAll($t->select()->where('id_config=?', $this->id));
		
		while(($row = $rows->current())!=null)
		{
			$obj = new Model_Configuration_Object($row->id_object, $this);
			$this->addObject($obj);
			
			$db = Zend_Db_Table::getDefaultAdapter ();
			$rowsAtt = $db->query('SELECT 	a.id as id
								FROM 	configurations_objects_attributes as c,
										objects_attributes as a
								WHERE 	c.id_attribute=a.id
										AND a.id_object='.$row->id_object)->fetchAll();

			foreach ($rowsAtt as $rowAtt)
			{
				$att = new Model_Configuration_Attribute($rowAtt['id'], $this);
				$obj->addAttribute($att);
			}
				
			$rows->next();
		}
		
	}
	
	public function loadAgents()
	{
		$t = new Model_Db_ConfigurationsAgents();
		$rows = $t->fetchAll($t->select()->where('id_config=?', $this->id));
		
		while(($row = $rows->current())!=null)
		{
			$obj = new Model_Configuration_Agent($row->id_agent, $this);
			$this->addAgent($obj);
			$rows->next();
		}
		
	}
	
	public function loadDirectives($id_parent=null)
	{
		$t = new Model_Db_ConfigurationsNodesTasks();
		if($id_parent==null)
			$rows = $t->fetchAll($t->select()->where('id_config=?', $this->id)->where('id_cnt_parent IS NULL')->order('ordre ASC'));
		else{
			$rows = $t->fetchAll($t->select()->where('id_config=?', $this->id)->where('id_cnt_parent=?', $id_parent)->order('ordre ASC'));
		}
		$res = array();
		while(($row = $rows->current())!=null)
		{
			$obj = new Model_Configuration_Directive($row->id_node, $this);
			$res[] = array('directive'=>$obj, 'children'=> $this->loadDirectives($row->id));
			$rows->next();
		}

		return $res;
	}
	
	
	
	public function loadReport($id_report)
	{
		$this->report = new Model_Configuration_Report($id_report, $this);
		
		$tRO = new Model_Db_ConfigurationsReportsOrder();
		$rowsOrders = $tRO->fetchAll($tRO->select()->where('id_report=?', $id_report)->order('ordre ASC'));
		
		while(($rowOrder=$rowsOrders->current())!=null)
		{
			switch($rowOrder->id_type)
			{
				// def
				case '1':
					$this->report->addParagraph($this->getReportObjects($rowOrder->id, $rowOrder->ordre));
				break;
				// agents
				case '2':
					$this->report->addParagraph($this->getReportAgents($rowOrder->id, $rowOrder->ordre));
				break;
				// directives
				case '3':
					$this->report->addParagraph($this->getReportDirectives($rowOrder->id, $rowOrder->ordre));
				break;
				// paragraphes
				case '4':
					$this->report->addParagraph($this->getReportParagraphs($rowOrder->id, $rowOrder->ordre));
				break;
			}
			$rowsOrders->next();
		}
		
		$t = new Model_Db_ConfigurationsReports();
		$row = $t->fetchRow($t->select()->where('id=?', $id_report));
		$this->name = $row->name;
	}
	
	public function getReportAgents($id_order, $order)
	{
		$tRA = new Model_Db_ConfigurationsReportsAgents();
		$rowRA = $tRA->fetchRow($tRA->select()->where('id_order=?', $id_order));
		return new Model_Configuration_ReportAgents($rowRA->title, $rowRA->layout, $order, $this->report);
	}
	
	public function getReportObjects($id_order, $order)
	{
		$tRO = new Model_Db_ConfigurationsReportsObjects();
		$rowRO = $tRO->fetchRow($tRO->select()->where('id_order=?', $id_order));
		return new Model_Configuration_ReportObjects($rowRO->title, $rowRO->layout, $order, $this->report);
	}
	
	public function getReportDirectives($id_order, $order)
	{
		$tRD = new Model_Db_ConfigurationsReportsDirectives();
		$rowRD = $tRD->fetchRow($tRD->select()->where('id_order=?', $id_order));
		return new Model_Configuration_ReportDirectives($rowRD->title, $rowRD->layout, $order, $this->report);
	}
	
	public function getReportParagraphs($id_order, $order)
	{
		$tRP = new Model_Db_ConfigurationsReportsParagraphs();
		$rowRP = $tRP->fetchRow($tRP->select()->where('id_order=?', $id_order));
		return new Model_Configuration_ReportParagraphs($rowRP->title, $rowRP->layout, $order, $rowRP->content, $rowRP->name, $this->report);
	}
	
	public function addAgent(Model_Configuration_Agent $agent)
	{
		$this->agents[$agent->id_agent] = $agent;
	}
	
	public function addObject(Model_Configuration_Object $obj)
	{
		$this->objects[$obj->id_object] = $obj;
	}
	
}
?>
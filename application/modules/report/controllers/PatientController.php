<?php

require_once 'Zend/Controller/Action.php';

class Report_PatientController extends Zend_Controller_Action {
	
	public function simpleviewAction() {
		
		$this->_helper->layout->setLayout ( 'report' );
		
		$tObjects = new Model_Db_Objects();
		$objects = $tObjects->fetchAll($tObjects->select())->toArray();
		
		$tAgents = new Model_Db_Agents();
		$agents = $tAgents->fetchAll($tAgents->select())->toArray();
		
		$this->view->agents = $agents;
		$this->view->objects = $objects;
	
	}
	
	public function simpleview2Action()
	{
		$this->_helper->layout->disableLayout();
		$cp = new Model_ClinicalPathway(1);
		$config = new Model_Configuration(1, 1);
		$this->view->cp = $cp;
		$this->view->config = $config;	
	}

}
?>
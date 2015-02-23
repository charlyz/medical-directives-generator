<?php

/**
 * IndexController - The default controller class
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class Report_ViewController extends Zend_Controller_Action 
{
	public function testpatientAction()
	{
		$this->_helper->layout->setLayout('report');
		$cp = new Model_ClinicalPathway(1);
		$config = new Model_Configuration(1, 1);
		$this->view->cp = $cp;
		$this->view->config = $config;	
	}
	
	public function testtachesAction()
	{
		$this->_helper->layout->setLayout('report');
		$cp = new Model_ClinicalPathway(1);
		$config = new Model_Configuration(2, 2);
		$this->view->cp = $cp;
		$this->view->config = $config;	
	}
	
}
?>
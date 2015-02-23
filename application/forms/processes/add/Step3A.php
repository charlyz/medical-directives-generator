<?php
// Décision
class Form_Processes_Add_Step3A extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		$this->setName ( 'process_add_step3A_form' );
		
		$ghmsc_graphs = new Zend_Form_Element_Hidden ( 'ghmsc_graphs' );
		$ghmsc_graphs->setValue ( $this->options ['ghmsc_graphs'] );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '3A' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$processes_type = new Zend_Form_Element_Hidden ( 'processes_type' );
		$processes_type->setValue ( $this->options ['processes_type'] );
		
		$process_name = new Zend_Form_Element_Hidden ( 'name' );
		$process_name->setValue ( $this->options ['name'] );
		
		$this->addElement ( 'hidden', 'id', array ('value' => 1 ) );
		
		// Submit
		$this->addElement ( 'submit', 'submit', array ('label' => 'Submit', 'order' => 93 ) );
		
		$this->addElements ( array ($ghmsc_graphs, $step, $clinic_pathways, $process_name, $processes_type ) );
	}
	
	/**
	 * Validation des éléments
	 * @param array $data données à valider
	 * $return bool 
	 */
	public function isValid($data) {
		$valid = parent::isValid ( $data );
		
		for($i = 0; $i < count ( $data ['txt'] ); $i ++)
			if ($data ['txt'] [$i] == '')
				return false;
		
		for($i = 0; $i < count ( $data ['node'] ); $i ++)
			if ($data ['node'] [$i] == '')
				return false;
		
		return $valid;
	}

}
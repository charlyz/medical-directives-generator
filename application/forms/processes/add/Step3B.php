<?php

class Form_Processes_Add_Step3B extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		$this->setName ( 'process_add_step3B_form' );
		
		$precondition = new Zend_Form_Element_Text ( 'precondition' );
		$precondition->setLabel ( 'Precondition:' )/*->setRequired ( true )*//*->addValidator ( 'NotEmpty' )*/;
		
		$definition = new Zend_Form_Element_Text ( 'definition' );
		$definition->setLabel ( 'Definition:' )/*->setRequired ( true )*//*->addValidator ( 'NotEmpty' )*/;
		
		$duration_min = new Zend_Form_Element_Text ( 'duration_min' );
		$duration_min->setLabel ( 'Minimum Duration (in sec): ' )/*->setRequired ( true )*//*->addValidator ( 'NotEmpty' )*/->addValidator ( 'int' );
		
		$duration_max = new Zend_Form_Element_Text ( 'duration_max' );
		$duration_max->setLabel ( 'Maximum Duration (in sec): ' )/*->setRequired ( true )*//*->addValidator ( 'NotEmpty' )*/->addValidator ( 'int' );
		
		$name = 'agents';
		$select = 'SELECT id, name FROM agents WHERE' . $this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Agent related to the task:';
		$agents = new Form_Element_DbMultiSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$agents->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		//$agents->setRequired(true);
		
		$name = 'objects';
		$select = 'SELECT id, name FROM objects WHERE' . $this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Agent related to the task:';
		$objects = new Form_Element_DbMultiSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$objects->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		//$objects->setRequired(true);
		
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Submit' );
		
		$ghmsc_graphs = new Zend_Form_Element_Hidden ( 'ghmsc_graphs' );
		$ghmsc_graphs->setValue ( $this->options ['ghmsc_graphs'] );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '3B' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$processes_type = new Zend_Form_Element_Hidden ( 'processes_type' );
		$processes_type->setValue ( $this->options ['processes_type'] );
		
		$process_name = new Zend_Form_Element_Hidden ( 'name' );
		$process_name->setValue ( $this->options ['name'] );
		
		$this->addElements ( array ($precondition, $definition, $duration_min, $duration_max, $agents, $objects, $submit, $ghmsc_graphs, $step, $clinic_pathways, $process_name, $processes_type ) );
	}
}
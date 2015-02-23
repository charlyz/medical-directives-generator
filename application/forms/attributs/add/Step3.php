<?php
// Décision
class Form_Attributs_Add_Step3 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		$this->setName ( 'attributs_add_step3_form' );
		
		$id_object = new Zend_Form_Element_Hidden ( 'id_object' );
		$id_object->setValue ( $this->options ['id_object'] );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '3' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$name = new Zend_Form_Element_Text ( 'name');
		$name -> setLabel('Nom:')->addValidator ( 'NotEmpty' );;
		
		$definition = new Zend_Form_Element_Text ( 'definition');
		$definition -> setLabel('Définition:');
		
		$this->addElement ( 'hidden', 'id', array ('value' => 1 ) );
		
		
		
		$this->addElements ( array ($id_object, $step, $clinic_pathways,$name, $definition) );
		// Submit
		$this->addElement ( 'submit', 'submit', array ('label' => 'Submit', 'order' => 93 ) );
	}
	
	/**
	 * Validation des éléments
	 * @param array $data données à valider
	 * $return bool 
	 */
	public function isValid($data) {
		$valid = parent::isValid ( $data );
		
		
		return $valid;
	}

}
<?php

class Form_Attributs_Add_Step2 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		
		// Création de la liste des graphes ghMSC
		$name = 'id_object';
		$select = 'SELECT id , name FROM objects WHERE id_cp=' . $this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Objet:';
		$id_object = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$id_object->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Suivant >' );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '2' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$this->addElements ( array ($id_object, $submit, $step, $clinic_pathways ) );
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
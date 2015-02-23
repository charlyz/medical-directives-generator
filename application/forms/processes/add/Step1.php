<?php

class Form_Processes_Add_Step1 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		
		// Création de la liste des itinéraires cliniques
		$name = 'clinic_pathways';
		$select = 'SELECT id, name FROM clinic_pathways';
		$value = 'name';
		$label = 'Clinical Pathways:';
		$cp = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$cp->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		// Création de la liste des types de processus
		$name = 'processes_type';
		$select = 'SELECT id, name FROM processes_types';
		$value = 'name';
		$label = 'Processes:';
		$pt = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$pt->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		// Champ texte du nom du processus à ajouter
		$process = new Zend_Form_Element_Text ( 'name' );
		$process->setLabel ( 'Name:' )->setRequired ( true )->addValidator ( 'NotEmpty' );
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Suivant >' );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '1' );
		
		$this->addElements ( array ($cp, $pt, $process, $submit, $step ) );
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
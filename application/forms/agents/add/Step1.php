<?php

class Form_Agents_Add_Step1 extends Zend_Form {
	
	/**
	 * Constructeur de formulaire d'ajout d'agents
	 * @param $options
	 */
	public function __construct($options = null) {		
		parent::__construct ( $options );
		
		// Nom du formulaire
		$this->setName ( 'agent_add_form' );
		
		// Création de la liste des itinéraires cliniques
		$name = 'clinic_pathways';
		$select = 'SELECT id, name FROM clinic_pathways';
		$value = 'name';
		$label = 'Clinical Pathways:';
		$cp = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$cp->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		// Champ texte pour le nom de l'agent
		$agent = new Zend_Form_Element_Text ( 'name');
		$agent -> setLabel('Name:')
		->setRequired ( true )->addValidator ( 'NotEmpty' );
		
		// Aire de texte pour la définition de l'agent
		$definition = new Zend_Form_Element_Textarea ( 'definition');
		$rows = 7;
		$cols = 50;
		$definition->setLabel('Definition:')
		->setRequired ( true )->addValidator ( 'NotEmpty' )->setAttrib ( 'rows', $rows )->setAttrib ( 'cols', $cols );
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit');
		$submit->setLabel('Envoyer');
		
		$this->addElements ( array ($cp, $agent, $definition, $submit ) );
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
<?php

class Form_Edges_Add_Step2 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		
		// Création de la liste des graphes ghMSC
		$name = 'ghmsc_graphs';
		$select = 'SELECT pg.id AS id, pn.name AS name FROM processes_graphs AS pg, processes_nodes AS pn WHERE pg.id_cp=' . $this->options ['clinic_pathways'].' AND pn.id = pg.id_node_parent';
		$value = 'name';
		$label = 'ghMSC Graphs:';
		$ghmsc = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$ghmsc->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		$tab_options = $ghmsc->options;
		$tab_options['1'] = 'Root';
		$ghmsc->setMultiOptions($tab_options);
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Suivant >' );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '2' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$this->addElements ( array ($ghmsc, $submit, $step, $clinic_pathways ) );
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
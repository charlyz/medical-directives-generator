<?php
// Décision
class Form_Edges_Add_Step3 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		$this->setName ( 'process_add_step3_form' );
		
		$ghmsc_graphs = new Zend_Form_Element_Hidden ( 'ghmsc_graphs' );
		$ghmsc_graphs->setValue ( $this->options ['ghmsc_graphs'] );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '3' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$name = 'id_node_from';
		$select = 'SELECT id, name FROM processes_nodes WHERE id_graph=' . $this->options ['ghmsc_graphs'];
		$value = 'name';
		$label = 'Noeud origine:';
		$id_node_from = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$id_node_from->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		$name = 'id_node_to';
		$select = 'SELECT id, name FROM processes_nodes WHERE id_graph=' . $this->options ['ghmsc_graphs'];
		$value = 'name';
		$label = 'Noeud origine:';
		$id_node_to = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$id_node_to->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		$duration_min = new Zend_Form_Element_Text ( 'duration_min');
		$duration_min -> setLabel('Durée min:');
		
		$duration_max = new Zend_Form_Element_Text ( 'duration_max');
		$duration_max -> setLabel('Durée max:');
		
		$this->addElement ( 'hidden', 'id', array ('value' => 1 ) );
		
		
		
		$this->addElements ( array ($ghmsc_graphs, $step, $clinic_pathways,$id_node_from, $id_node_to, $duration_min, $duration_max ) );
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
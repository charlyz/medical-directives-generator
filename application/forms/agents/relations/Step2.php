<?php

class Form_Agents_Relations_Step2 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( null );
		$this->options = $options;
		
		$name = 'id_agent_control';
		$select = 'SELECT id, name FROM agents WHERE  id_cp='.$this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Control agent:';
		$ac = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$ac->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		$name = 'id_agent_monitor';
		$select = 'SELECT id, name FROM agents WHERE  id_cp='.$this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Monitor agent:';
		$am = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$am->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		$name = 'id_attribute';
		$select = 'SELECT a.id as id, CONCAT_WS(\'>\', o.name, a.name) as name FROM objects as o, objects_attributes as a WHERE  o.id_cp='.$this->options ['clinic_pathways'].' and a.id_object=o.id';
		$value = 'name';
		$label = 'Attribut:';
		$o = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$o->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );

		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Envoyer' );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '2' );
		
		$this->addElements ( array ($ac, $am, $o, $submit, $step, $clinic_pathways ) );
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
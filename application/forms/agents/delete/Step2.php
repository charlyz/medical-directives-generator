<?php
/**
 * Cette classe créer le  premier formulaire de suppression d'un agent.
 * La suppression d'un agent se fait en deux étapes:
 * (1) Il faut sélectionner l'itinéraire clinique duquel on
 *     veut supprimer l'agent (classe Step1.php)
 * (2) Il faut choisir l'agent à supprimer (cette classe)
 * 
 * La suppression de l'agent ne s'effectue que lorsque toutes
 * les étapes ont été exécutées
 * 
 * @author Quentin Pirmez <quentin.pirmez@student.uclouvain.be>
 */
class Form_Agents_Delete_Step2 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = NULL) {
		parent::__construct ( $options );
		$this->options = $options;
		
		// Création de la liste des agents
		$name = 'agents';
		$select = 'SELECT id, name FROM agents WHERE id_cp=' . $this->options ['clinic_pathways'];
		$value = 'name';
		$label = 'Agents:';
		$ag = new Form_Element_DbSelect ( array ('name' => $name, 'dbSelect' => $select, 'valueColumn' => $value, 'label' => $label ) );
		$ag->addValidator ( new Zend_Validate_GreaterThan ( - 1 ), false );
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Suivant >' );
		
		$step = new Zend_Form_Element_Hidden('step');
		$step->setValue('2');
		
		$clinic_pathways = new Zend_Form_Element_Hidden('clinic_pathways');
		$clinic_pathways->setValue($this->options ['clinic_pathways']);
		
		$this->addElements ( array ($ag, $submit, $step, $clinic_pathways ) );
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
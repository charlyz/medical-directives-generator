<?php
/**
 * Cette classe créer le  premier formulaire d'édition d'un agent.
 * L'édition d'un agent se fait en trois étapes:
 * (1) Il faut sélectionner l'itinéraire clinique duquel on
 *     veut éditer l'agent (cette classe)
 * (2) Il faut choisir l'agent à éditer (classe edit/Step2.php)
 * (3) Il faut afficher le formulaire d'édition de l'agent
 *     sélectionné (classe edit/Step3.php
 * 
 * L'édition de l'agent ne s'effectue que lorsque toutes
 * les étapes ont été exécutées
 * 
 * @author Quentin Pirmez <quentin.pirmez@student.uclouvain.be>
 */
class Form_Agents_Edit_Step1 extends Zend_Form{
	
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
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Suivant >' );
		
		$step = new Zend_Form_Element_Hidden('step');
		$step->setValue('1');
		
		$this->addElements ( array ($cp, $submit, $step ) );
	
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

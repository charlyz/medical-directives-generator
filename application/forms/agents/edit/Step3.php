<?php
/**
 * Cette classe créer le  premier formulaire d'édition d'un agent.
 * L'édition d'un agent se fait en trois étapes:
 * (1) Il faut sélectionner l'itinéraire clinique duquel on
 *     veut éditer l'agent (classe  edit/Step1.php)
 * (2) Il faut choisir l'agent à éditer (classe edit/Step2.php)
 * (3) Il faut afficher le formulaire d'édition de l'agent
 *     sélectionné (cette classe)
 * 
 * L'édition de l'agent ne s'effectue que lorsque toutes
 * les étapes ont été exécutées
 * 
 * @author Quentin Pirmez <quentin.pirmez@student.uclouvain.be>
 */
class Form_Agents_Edit_Step3 extends Zend_Form {
	
	public $options;
	
	public function __construct($options = null) {
		parent::__construct ( null );
		$this->options = $options;
		
		// Champ texte pour le nom de l'agent
		$agent = new Zend_Form_Element_Text ( 'name' );
		$agent->setLabel ( 'Name:' )->setRequired ( true )->addValidator ( 'NotEmpty' );
		
		// Aire de texte pour la définition de l'agent
		$definition = new Zend_Form_Element_Textarea ( 'definition' );
		$rows = 7;
		$cols = 50;
		$definition->setLabel ( 'Definition:' )->setRequired ( true )->addValidator ( 'NotEmpty' )->setAttrib ( 'rows', $rows )->setAttrib ( 'cols', $cols );
		
		// Bouton de soumission 
		$submit = new Zend_Form_Element_Submit ( 'submit' );
		$submit->setLabel ( 'Envoyer' );
		
		$step = new Zend_Form_Element_Hidden ( 'step' );
		$step->setValue ( '3' );
		
		$clinic_pathways = new Zend_Form_Element_Hidden ( 'clinic_pathways' );
		$clinic_pathways->setValue ( $this->options ['clinic_pathways'] );
		
		$agents = new Zend_Form_Element_Hidden ( 'agents' );
		$agents->setValue ( $this->options ['agents'] );
		
		$this->addElements ( array ($agent, $definition, $submit, $step, $clinic_pathways, $agents ) );
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
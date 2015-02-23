<?php

require_once 'Zend/Controller/Action.php';

class Admin_AttributsController extends Zend_Controller_Action {
	
public function addAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'ajout
		$form = new Form_Attributs_Add_Step1 ( );
		
		// Si la page est postée = formulaire envoyé
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			switch ($data ['step']) {
				
				case 1 :
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire de suppression étape 2
						$form = new Form_Attributs_Add_Step2 ( $data );
					}
					break;
				
				case 2 :
					
					// Création du formulaire de suppression étape 2
					$form = new Form_Attributs_Add_Step2 ( $data );
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {

						$form = new Form_Attributs_Add_Step3 ( $data );
									
					}
					break;
					
				case '3' :
					$form = new Form_Attributs_Add_Step3 ( $data );
					
					if ($form->isValid ( $data ))
					{
						try{
							$this->convertEmptyStringToNull ( $data );
							$t = new Model_Db_ObjectsAttributes ( );
							$row = $t->createRow ( array ('id_object' => $data ['id_object'], 'name' => $data ['name'], 'definition' => $data ['definition']) );
							$row->save ();
							
							
							// Ajouter un message pour confirmé l'ajout du record dans la base de données
							$this->addMsg ( 'Attribut ajoutée' );
							
							// Ré-initialiser le formulaire d'ajout
							$form = new Form_Attributs_Add_Step1 ( );
						} catch ( Zend_Exception $e ) {
						
						// Si un exception est captée, afficher le message d'erreur
						$this->addMsg ( $e );
					
						}
					}
					break;
			}
		
		}
		
		// Assigner le formulaire à la vue
		$this->view->Msgs = Zend_Registry::get ( 'Notices' );
		$this->view->form = $form;
	}
	
	public function convertEmptyStringToNull($data) {
		foreach ( $data as $k => $v ) {
			if (! is_array ( $v ) && trim ( $v ) == '')
				$data [$k] = null;
			elseif (is_array ( $v )) {
				foreach ( $v as $k2 => $v2 )
					if (trim ( $v2 ) == '')
						$data [$k] [$k2] = null;
			}
		}
		return $data;
	}
	
	public function addMsg($e) {
		$notices = Zend_Registry::get ( 'Notices' );
		if ($e instanceof Zend_Exception)
			$notices [] = 'Message de ' . get_class ( $e ) . ': ' . $e->getMessage ();
		else
			$notices [] = $e;
		Zend_Registry::set ( 'Notices', $notices );
	}
}
?>
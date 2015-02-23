<?php

require_once 'Zend/Controller/Action.php';

class Admin_ObjectsController extends Zend_Controller_Action {
	
	/**
	 * Ajouter un objet
	 */
	public function addAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'ajout
		$form = new Form_Objects_Add_Step1 ( );
		
		// Si la page est postée = formulaire envoyé
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			// Si les données entrées dans le formulaire sont valides
			if ($form->isValid ( $data )) {
				
				try {
					// Crée un modèle de base de donnée pour accéder à la table agent de notre base de donnée
					$t = new Model_Db_Objects ( );
					
					// Crée un record avec les données du formulaire à enregistrer dans la base de données
					$row = $t->createRow ( array ('id_cp' => $data ['clinic_pathways'], 'name' => $data ['name'], 'definition' => $data ['definition'] ) );
					
					// Enregistrer le record dans la base de données
					$row->save ();
					
					// Ajouter un message pour confirmé l'ajout du record dans la base de données
					$this->addMsg ( 'Objet ajouté' );
					
					// Ré-initialiser le formulaire d'ajout
					$form = new Form_Objects_Add_Step1 ( );
				
				} catch ( Zend_Exception $e ) {
					
					// Si un exception est captée, afficher le message d'erreur
					$this->addMsg ( $e );
				
				}
			
			}
		}
		
		// Assigner le formulaire à la vue
		$this->view->Msgs = Zend_Registry::get ( 'Notices' );
		$this->view->form = $form;
	
	}

	/**
	 * Fonction pour remplacer les champs vides du formulaire par null
	 * @param $data données enregistrées du formulaire
	 */
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
	
	/**
	 * Fonction d'affichage de messages
	 * @param $e
	 */
	public function addMsg($e) {
		$notices = Zend_Registry::get ( 'Notices' );
		if ($e instanceof Zend_Exception)
			$notices [] = 'Message de ' . get_class ( $e ) . ': ' . $e->getMessage ();
		else
			$notices [] = $e;
		Zend_Registry::set ( 'Notices', $notices );
	}
}
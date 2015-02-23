<?php

require_once 'Zend/Controller/Action.php';

class Admin_AgentsController extends Zend_Controller_Action {
	
	/**
	 * Ajouter un agent
	 */
	public function addAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'ajout
		$form = new Form_Agents_Add_Step1 ( );
		
		// Si la page est postée = formulaire envoyé
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			// Si les données entrées dans le formulaire sont valides
			if ($form->isValid ( $data )) {
				
				try {
					// Crée un modèle de base de donnée pour accéder à la table agent de notre base de donnée
					$tAgents = new Model_Db_Agents ( );
					
					// Crée un record avec les données du formulaire à enregistrer dans la base de données
					$rowAgent = $tAgents->createRow ( array ('id_cp' => $data ['clinic_pathways'], 'name' => $data ['name'], 'definition' => $data ['definition'] ) );
					
					// Enregistrer le record dans la base de données
					$rowAgent->save ();
					
					// Ajouter un message pour confirmé l'ajout du record dans la base de données
					$this->addMsg ( 'Agent ajouté' );
					
					// Ré-initialiser le formulaire d'ajout
					$form = new Form_Agents_Add_Step1 ( );
				
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
	
	public function relationsAction()
	{
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'ajout
		$form = new Form_Agents_Relations_Step1();
		
		// Si la page est postée = formulaire envoyé
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			switch ($data ['step']) {
				
				case 1 :
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire de suppression étape 2
						$form = new Form_Agents_Relations_Step2($data);
					}
					break;
				
				case 2 :
					
					// Création du formulaire de suppression étape 2
					$form = new Form_Agents_Relations_Step2 ( $data );
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) 
					{
						$t = new Model_Db_AgentsRelationsObjects();
						$row = $t->createRow ( array ('id_agent_control' => $data ['id_agent_control'], 'id_agent_monitor' => $data ['id_agent_monitor'], 'id_attribute' => $data ['id_attribute'] ) );
						$row->save ();
						$form = new Form_Agents_Relations_Step1();
						$this->addMsg('Relation ajoutée');
					}
					break;
			}
		}
		// Assigner le formulaire à la vue
		$this->view->Msgs = Zend_Registry::get ( 'Notices' );
		$this->view->form = $form;
	}
	
	/**
	 * Supprimer d'un agent
	 */
	public function deleteAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire de suppression étape 1
		$form = new Form_Agents_Delete_Step1 ( );
		
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			switch ($data ['step']) {
				case '1' :
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire de suppression étape 2
						$form = new Form_Agents_Delete_Step2 ( $data );
					}
					break;
				
				case '2' :
					
					// Création du formulaire de suppression étape 2
					$form = new Form_Agents_Delete_Step2 ( $data );
					
					// Si les données du formulaire de l'étape 2 sont valides
					if ($form->isValid ( $data )) {
						
						// On supprime l'agent
						try {
							$tAgents = new Model_Db_Agents ( );
							$rowAgent = $tAgents->find ( $data ['agents'] )->current ();
							$rowAgent->delete ();
							$this->addMsg ( 'Agent supprimé' );
							$form = new Form_Agents_Delete_Step1 ( );
						} catch ( Zend_Exception $e ) {
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
	
	/**
	 * Editer un agent
	 */
	public function editAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'édition étape 1
		$form = new Form_Agents_Edit_Step1 ( );
		
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			switch ($data ['step']) {
				case '1' :
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire d'édition étape 2
						$form = new Form_Agents_Edit_Step2 ( $data );
					}
					break;
				
				case '2' :
					
					// Création du formulaire d'édition étape 2
					$form = new Form_Agents_Edit_Step2 ( $data );
					
					// Si les données du formulaire de l'étape 2 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire d'édition étape 3
						$form = new Form_Agents_Edit_Step3 ( $data );
						
						// Récupérer les infos existantes sur l'agent
						$tAgents = new Model_Db_Agents ( );
						$rowAgent = $tAgents->find ( $data ['agents'] )->current ();
						$data ['name'] = $rowAgent ['name'];
						$data ['definition'] = $rowAgent ['definition'];
						$data ['step'] = 3;
						$form->populate ( $data );
					
					}
					break;
				
				case '3' :
					
					// Création du formulaire d'édition étape 3
					$form = new Form_Agents_Edit_Step3 ( $data );
					
					// Si les données du formulaire de l'étape 3 sont valides
					if ($form->isValid ( $data )) {
						// Mis à jour de donnée de l'agent
						try {
							$this->convertEmptyStringToNull ( $data );
							$tAgents = new Model_Db_Agents ( );
							$data_to_update = array ('name' => $data ['name'], 'definition' => $data ['definition'] );
							$where = $tAgents->getAdapter ()->quoteInto ( 'id = ?', $data ['agents'] );
							$tAgents->update ( $data_to_update, $where );
							$this->addMsg ( 'Agent mis à jour' );
							$form = new Form_Agents_Edit_Step1 ( );
						} catch ( Zend_Exception $e ) {
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
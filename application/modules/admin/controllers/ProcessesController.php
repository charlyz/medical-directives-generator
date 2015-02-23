<?php

require_once 'Zend/Controller/Action.php';

class Admin_ProcessesController extends Zend_Controller_Action {
	
	/**
	 * Ajouter un élement de workflow
	 */
	public function addAction() {
		
		// On utilise le layout admin pour la mise en page
		$this->_helper->layout->setLayout ( 'admin' );
		
		// Création du formulaire d'ajout
		$form = new Form_Processes_Add_Step1 ( );
		
		// Si la page est postée = formulaire envoyé
		if ($this->_request->isPost ()) {
			
			// Récupération des données envoyées par le formulaire
			$data = $this->getRequest ()->getPost ();
			
			switch ($data ['step']) {
				
				case 1 :
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						// Création du formulaire de suppression étape 2
						$form = new Form_Processes_Add_Step2 ( $data );
					}
					break;
				
				case 2 :
					
					// Création du formulaire de suppression étape 2
					$form = new Form_Processes_Add_Step2 ( $data );
					
					// Si les données du formulaire de l'étape 1 sont valides
					if ($form->isValid ( $data )) {
						
						try {
							$this->convertEmptyStringToNull ( $data );
							
							// Créer un modèle de base de donnée pour accéder à la table processes_types
							// Récupérer le nom du type de processus correspondant à l'id du type de processus sélectionné
							$tType = new Model_Db_ProcessesTypes ( );
							$process_type = $tType->fetchRow ( $tType->select ()->where ( 'id=?', $data ['processes_type'] ) );
							
							switch ($process_type->name) {
								
								case 'Decision' :
									
									// Ré-initialiser le formulaire d'ajout
									$form = new Form_Processes_Add_Step3A ( $data );
									
									// Créer un modèle de base de donnée pour accéder à la table processes_nodes
									// Récupérer les nodes tâches correspondant à l'id du graphe ghmsc sélectionné
									$tNode = new Model_Db_ProcessesNodes ( );
									$result = $tNode->fetchAll ( $tNode->select ()->where ( 'id_graph=?', $data ['ghmsc_graphs'] )->where ( 'id_type=?', 7 ) );
									
									// Créer un nouveau talbeau
									$tab = array ();
									
									// Remplir le tableau avec le résultat de la requête
									// càd avec le nom des tâches contenu dans le graphe sélectionné
									while ( ($node = $result->current ()) != null ) {
										$tab [$node->id] = $node->name;
										$result->next ();
									}
									
									$this->view->script = $this->construisTableauJS ( $tab, "monTableauJS" );
									$this->view->showAddCondition = true;
									break;
								
								case 'Task' :
									
									// Ré-initialiser le formulaire d'ajout
									$form = new Form_Processes_Add_Step3B ( $data );
									
									break;
								default :
									
									// Crée un modèle de base de donnée pour accéder à la table node de notre base de donnée
									$tNode = new Model_Db_ProcessesNodes ( );
									
									// Crée un record avec les données du formulaire à enregistrer dans la base de données
									$rowNode = $tNode->createRow ( array ('id_type' => $data ['processes_type'], 'id_graph' => $data ['ghmsc_graphs'], 'name' => $data ['name'] ) );
									
									// Enregistrer le record dans la base de données
									$rowNode->save ();
									
									// Ajouter un message pour confirmé l'ajout du record dans la base de données
									$this->addMsg ( 'Processus ajouté' );
									
									// Ré-initialiser le formulaire d'ajout
									$form = new Form_Processes_Add_Step1 ( );
									
									break;
							
							}
						
						} catch ( Zend_Exception $e ) {
							$this->addMsg ( $e );
							// Ré-initialiser le formulaire d'ajout
							$form = new Form_Processes_Add_Step1 ( );
						}
					}
					
					break;
				case '3A' :
					$form = new Form_Processes_Add_Step3A ( $data );
					
					if ($form->isValid ( $data )) {
						$tNodes = new Model_Db_ProcessesNodes ( );
						$rowNode = $tNodes->createRow ( array ('id_type' => 2, 'name' => $data ['name'], 'id_graph' => $data ['ghmsc_graphs'] ) );
						$rowNode->save ();
						
						$i = 0;
						while ( $i < count ( $data ['txt'] ) ) {
							$t = new Model_Db_ProcessesEdges ( );
							$rowEdge = $t->createRow ( array ('id_node_from' => $rowNode->id, 'id_node_to' => $data ['node'] [$i] ) );
							$rowEdge->save ();
							
							$t = new Model_Db_ProcessesConditions ( );
							$rowCond = $t->createRow ( array ('id_node' => $rowNode->id, 'name' => $data ['txt'] [$i], 'id_edge' => $rowEdge->id ) );
							$rowCond->save ();
							$i ++;
						}
						
						// Ajouter un message pour confirmé l'ajout du record dans la base de données
						$this->addMsg ( 'Décision ajoutée' );
						
						// Ré-initialiser le formulaire d'ajout
						$form = new Form_Processes_Add_Step1 ( );
						
					} else {
						// Créer un modèle de base de donnée pour accéder à la table processes_nodes
						// Récupérer les nodes tâches correspondant à l'id du graphe ghmsc sélectionné
						$tNode = new Model_Db_ProcessesNodes ( );
						$result = $tNode->fetchAll ( $tNode->select ()->where ( 'id_graph=?', $data ['ghmsc_graphs'] )->where ( 'id_type=?', 7 ) );
						
						// Créer un nouveau talbeau
						$tab = array ();
						
						// Remplir le tableau avec le résultat de la requête
						// càd avec le nom des tâches contenu dans le graphe sélectionné
						while ( ($node = $result->current ()) != null ) {
							$tab [$node->id] = $node->name;
							$result->next ();
						}
						
						$this->view->script = $this->construisTableauJS ( $tab, "monTableauJS" );
						$this->view->showAddCondition = true;
						$this->addMsg ( 'Veuillez donner un nom à chaque condition.' );
					}
					
					break;
				case '3B' :
					$form = new Form_Processes_Add_Step3B ( $data );
					
					if ($form->isValid ( $data )) {
						try{
							// Ajouter le node correspondant à la tâche dans processes_nodes
							$tNodes = new Model_Db_ProcessesNodes ( );
							$rowNode = $tNodes->createRow ( array ('id_type' => 7, 'name' => $data ['name'], 'id_graph' => $data ['ghmsc_graphs'] ) );
							$rowNode->save ();
							
							// Ajouter la tâche dans processes_tasks
							$tTasks = new Model_Db_ProcessesTasks ( );
							$data = $this->convertEmptyStringToNull ( $data );
							$rowTask = $tTasks->createRow ( array ('id_node' => $rowNode->id, 'precondition' => $data ['precondition'], 'definition' => $data ['definition'], 'duration_min' => $data ['duration_min'], 'duration_max' => $data ['duration_max'] ) );
							$rowTask->save ();
							
							if(isset($data ['agents']) && is_array($data ['agents']))
							{
								for($i = 0; $i < count ( $data ['agents'] ); $i ++) {
									// Ajouter les agents liés à la tâche dans task_relations_agents
									$tRelation = new Model_Db_ProcessesTasksRelationsAgents ( );
									$rowRelation = $tRelation->createRow ( array ('id_node' => $rowNode->id, 'id_agent' => $data ['agents'] [$i] ) );
									$rowRelation->save ();
								}
							}
							if(isset($data ['objects']) && is_array($data ['objects']))
							{
								for($i = 0; $i < count ( $data ['objects'] ); $i ++) {
									// Ajouter les agents liés à la tâche dans task_relations_agents
									$tRelation = new Model_Db_ProcessesTasksRelationsObjects ( );
									$rowRelation = $tRelation->createRow ( array ('id_node' => $rowNode->id, 'id_object' => $data ['objects'] [$i] ) );
									$rowRelation->save ();
								}
							}
							
							// Ajouter un message pour confirmé l'ajout du record dans la base de données
							$this->addMsg ( 'Tâche ajouté' );
							
							// Ré-initialiser le formulaire d'ajout
							$form = new Form_Processes_Add_Step1 ( );
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
	
	/**
	 * Transformer un tableau php en un tableau javascript
	 * @param $tableauPHP tableau PHP
	 * @param $nomTableauJS tableau Javascript
	 * @return tableau Javascript
	 */
	function construisTableauJS($tableauPHP, $nomTableauJS) {
		$res = $nomTableauJS . " = new Array();";
		foreach ( $tableauPHP as $key => $value ) {
			if (! is_array ( $value )) {
				$res .= $nomTableauJS . "[\"" . $key . "\"] = \"" . $value . "\";";
			} else {
				$res .= $this->construisTableauJS ( $value, $nomTableauJS . "[\"" . $key . "\"]" );
			}
		}
		return $res;
	}
	
	/**
	 * Supprimer un élement de workflow
	 */
	public function deleteAction() {
	
	}
	
	/**
	 * Editer un élement de workflow
	 */
	public function editAction() {
	
	}
	
	/**
	 * Fonction de prévisualisation d'un processus
	 * 
	 */
	public function previewAction() {
		$this->_helper->layout->setLayout ( 'admin' );
		$id_ghmsc = $this->_getParam ( 'id_ghmsc', 1 );
		$cp = new Model_ClinicalPathway ( 1 );
		$ghmsc = $cp->getGhmscById ( $id_ghmsc );
		$nodes = $ghmsc->nodes;
		
		foreach ( $nodes as $node ) {
			if ($node instanceof Model_Process_Task) {
				if ($node->isGhmsc ())
					$node->url = $this->getBaseUrl () . '/admin/processes/preview/id_ghmsc/' . $node->under_graph->id;
			}
		}
		
		$render = $ghmsc->render ();
		$this->view->graphImgSrc = $render [0];
		$this->view->graphMapContent = $render [1];
		$this->view->Msgs = Zend_Registry::get ( 'Notices' );
	}
	
	function getBaseUrl() {
		$fc = Zend_Controller_Front::getInstance ();
		$request = $fc->getRequest (); /* @var $request Zend_Controller_Request_Http */
		return $request->getBaseUrl ();
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
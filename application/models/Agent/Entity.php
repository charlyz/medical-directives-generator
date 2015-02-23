<?php
/**
 * Fichier dans le dossier Model/Agent/
 * 
 * Cette classe permet de crée une Entité du modèle Agents
 * 
 * @author Quentin Pirmez <quentin.pirmez@student.uclouvain.be>
 *
 */
class Model_Agent_Entity {
	/**
	 * L' <b>id</b> de l'entité agent
	 */
	public $id;
	
	/**
	 * Le <b>nom</b> le nom de l'entité agent
	 * 
	 */
	public $name;
	
	/*
	 * La <b>definition</b> de l'agent
	 */
	public $definition;
	
	/*
	 * Les <b>décorations</b> accroché à l'entité agent
	 */
	public $decorations;
	
	/**
	 * Le <b>graphe</b> dans lequelle se trouve l'entité agent
	 */
	public $graph;
	
	/**
	 * Constructeur de l'entité agent
	 * 
	 * @param Model_Agent_Graph $id 
	 * @param $graph
	 */
	public function Model_Agent_Entity($id, Model_Agent_Graph $graph) {
		$this->graph = $graph;
		$this->id = $id;
		$tAgents = new Model_Db_Agents ( );
		$rowAgent = $tAgents->fetchAll ( $tAgents->select ()->where ( 'id=?', $this->id ) )->current ();
		$this->name = $rowAgent->name;
		$this->definition = $rowAgent->definition;
	}
	
	/**
	 * Récupérer un tableau des décorations accrochées à une entité du modèle Agent
	 */
	public function decorations() {
		if ($this->decorations != null)
			return $this->decorations;
		
		$tAgentDeco = new Model_Db_AgentsDecorations ( );
		$rowsAD = $tAgentDeco->fetchAll ( $tAgentDeco->select ()->where ( 'id_agent = ?', $this->id ) );
		$this->decorations = array ();
		
		while ( ($rowAD = $rowsAD->current ()) != null ) {
			$type = $rowAD->findModel_Db_AgentsDecorationsTypes ()->current ()->name;
			$ad = new Model_Agent_Decoration ( $rowAD->id, $this, $rowAD->decoration, $type );
			$this->decorations [$rowAD->id] = $ad;
			$rowsAD->next ();
		}
		return $this->decorations;
	}
	
	/**
	 * Récupérer les décorations à partir d'une configuration d'agents
	 * 
	 * @param Model_Configuration_Agent $cAg
	 * @return unknown_type
	 */
	public function getDecorationsFromAgentConfig(Model_Configuration_Agent $cAg) {
		$decos = $this->decorations ();
		$res = array ();
		foreach ( $cAg->idsDecoration () as $id_decoration ) {
				$res [$id_decoration] = $decos [$id_decoration];
		}
		
		return $res;
	}
	
	public function getTemplateMappingArray(Model_Configuration_Agent $aConf)
	{
		$res = array();
		$decos = $this->getDecorationsFromAgentConfig($aConf);
		$definition = $this->definition;
		$res['decoration'] = array();
		foreach($decos as $k=>$deco)
		{
			if($deco->type == 'definition')
			{
				$definition = $deco->decoration;
			}else
			{
				$res/*['decoration']*/[$deco->type] = $deco->decoration;
			}
		}
		
		$res['id'] = $this->id;
		$res['nom'] = $this->name;
		$res['definition'] = $definition;
		return $res;
	}
}
?>
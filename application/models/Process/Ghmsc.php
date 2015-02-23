<?php

class Model_Process_Ghmsc {
	//public $dotPath = "C:\\Program Files (x86)\\Graphviz2.26.3\\bin\\dot.exe";
	public $dotPath;
	public $nodes = array ();
	public $edges = array ();
	public $cachePath;
	public $wwwCachePath;
	public $nodeParent;
	public $firstNode;
	public $cp;
	public $id;
	
	public function Model_Process_Ghmsc($id, Model_ClinicalPathway $cp, Model_Process_Node $nodeParent = null) {
		$this->dotPath = GRAPHVIZ_PATH;
		$this->id = $id;
		$this->cp = $cp;
		$this->nodeParent = $nodeParent;
		$this->cachePath = GRAPHVIZ_CACHEPATH;
		$this->wwwCachePath = GRAPHVIZ_WWWCACHEPATH;
		$this->load ();
	}
	
	public function load() {
		$tNodes = new Model_Db_ProcessesNodes ( );
		$rowsNodes = $tNodes->fetchAll ( $tNodes->select ()->where ( 'id_graph=?', $this->id ) );
		
		while ( ($rowNode = $rowsNodes->current ()) != null ) {
			//$type = $rowNode->id_type;
			$type = $rowNode->findModel_Db_ProcessesTypes ()->current ()->name;
			$class = 'Model_Process_' . $type;
			$node = new $class ( $rowNode->id, $this );
			$this->addNode ( $node );
			
			if ($node instanceof Model_Process_Start)
				$this->firstNode = $node;
				
			/*switch($type)
			{
				case '1': $node = new Model_Process_Blank($rowNode->id, $this); break;
				case '2': $node = new Model_Process_Decision($rowNode->id, $this); break;
				case '3': $node = new Model_Process_End($rowNode->id, $this); break;
				case '4': $node = new Model_Process_Fork($rowNode->id, $this); break;
				case '5': $node = new Model_Process_Join($rowNode->id, $this); break;
				case '6': $node = new Model_Process_Start($rowNode->id, $this); break;
				case '7': $node = new Model_Process_Task($rowNode->id, $this); break;
			}*/
			$rowsNodes->next ();
		}
		
		foreach ( $this->nodes as $nodeFrom ) {
			$tEdges = new Model_Db_ProcessesEdges ( );
			$rowsEdges = $tEdges->fetchAll ( $tEdges->select ()->where ( 'id_node_from=?', $nodeFrom->id ) );
			
			while ( ($rowEdge = $rowsEdges->current ()) != null ) {
				$nodeTo = $this->getNodeFromId ( $rowEdge->id_node_to );
				
				$rowsConditions = $rowEdge->findModel_Db_ProcessesConditions ();
				$name = null;
				if ($rowsConditions->count () > 0) {
					$rowCondition = $rowsConditions->current ();
					$name = $rowCondition->name;
				}
				$edge = new Model_Process_Edge ( $nodeFrom, $nodeTo, $name, $rowEdge->duration_min, $rowEdge->duration_max );
				$this->addEdge ( $edge );
				
				$rowsEdges->next ();
			}
		}
	
	}
	
	public function setNodeParent(Model_Process_Node $n) {
		$this->nodeParent = $n;
	}
	
	public function addNode(Model_Process_Node $node) {
		$this->nodes [$node->name ()] = $node;
	}
	
	public function getNodeFromId($id) {
		foreach ( $this->nodes as $n ) {
			if ($n->id () == $id) {
				return $n;
			}
		}
		return null;
	}
	
	public function getNodeFromIdInAllGraphs($id, Model_Process_Ghmsc $ghmsc = null)
	{	
		if($ghmsc == null)
			$ghmsc = $this;
		
		foreach ( $ghmsc->nodes as $n ) {
			if ($n->id () == $id) {
				return $n;
			}
		}
		
		$nodes = $ghmsc->nodes;
		
		foreach($nodes as $node)
		{
			if($node instanceof Model_Process_Task)
			{
				if($node->isGhmsc())
				{
					$nextGhmsc = $node->under_graph;
					$res = $this->getNodeFromIdInAllGraphs($id, $nextGhmsc);
					
					if($res != null)
						return $res;
				}
			}
		}
		return null;
		
	}
	
	/*public function addEdge(Node $from, Node $to, $name=null)
	{
		$e = new Edge($from, $to, $name);
		$this->edges[$from->name().'-'.$to->name()] = $e;
	}*/
	
	public function addEdge(Model_Process_Edge $e) {
		$this->edges [$e->from->name () . '-' . $e->to->name ()] = $e;
	}
	
	/*
	 * Supprime un noeud ainsi que les ar�tes entrantes et sortantes.
	 */
	public function removeNode(Model_Process_Node $n) {
		unset ( $this->nodes [$n->name ()] );
		
		foreach ( $this->edges as $k => $edge ) {
			if ($edge->from->name () == $n->name () || $edge->to->name () == $n->name ()) {
				unset ( $this->edges [$k] );
			}
		}
	}
	
	/*
	 * Supprime la tache et modifie les ar�tes entrantes et sortantes
	 */
	public function removeTask(Model_Process_Task $n) {
		unset ( $this->nodes [$n->name ()] );
		
		$to = null;
		foreach ( $this->edges as $k => $edge ) {
			if ($edge->from->name () == $n->name ()) {
				$to = $edge->to;
				unset ( $this->edges [$k] );
				break;
			}
		}
		
		foreach ( $this->edges as $k => $edge ) {
			if ($edge->to->name () == $n->name ()) {
				if ($to != null)
					$edge->to = $to;
				else
					unset ( $this->edges [$k] );
			}
		}
	}
	
	public function getUnreachableNodes() {
	
	}
	
	public function removeDecision(Model_Process_Decision $n, Model_Process_Node $defaultNode) {
		unset ( $this->nodes [$n->name ()] );
		
		$to = $defaultNode;
		
		foreach ( $this->edges as $edge ) {
			if ($edge->to->name () == $n->name ()) {
				$edge->to = $to;
			}
		}
	}
	
	public function removeEdge(Model_Process_Node $from, Model_Process_Node $to) {
		unset ( $this->edges [$from->name () . '-' . $to->name ()] );
	}
	
	public function generateCode() {
		$res = "digraph G {\n";
		
		foreach ( $this->nodes as $n ) {
			$res .= "\"" . $n->name () . "\" [" . (trim ( $n->color () ) != '' ? "color=\"" . $n->color () . "\"" : "") . " " . (trim ( $n->url () ) != '' ? "URL=\"" . $n->url () . "\"" : "") . " " . (trim ( $n->shape () ) != '' ? " shape=\"" . $n->shape () . "\"" : "") . "]\n";
		}
		
		foreach ( $this->edges as $e ) {
			$res .= "\"" . $e->from->name () . "\" -> \"" . $e->to->name () . "\" [" . (trim ( $e->name ) != '' ? "label=\"" . $e->name . "\"" : "") . "]\n";
		}
		
		$res .= "\n}";
		return $res;
	}
	
	public function deleteOldFiles() {
		if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN')
			$rep = $this->cachePath . "\\";
		else
			$rep = $this->cachePath . "/";
		$handle = opendir ( $rep );
		while ( ($f = readdir ( $handle )) !== false ) {
			if (is_file ( $rep . $f )) {
				$time = time () - 60 * 60;
				if (filectime ( $rep . $f ) < $time)
					unlink ( $rep . $f );
			}
		}
	}
	
	public function render() {
		if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
			return $this->renderWindows ();
		} else {
			return $this->renderMac ();
		}
	}
	
	public function renderWindows() {
		$res = array ();
		$this->deleteOldFiles ();
		
		$tempid = time ();
		$code = $this->generateCode ();
		$codePath = $this->cachePath . '\\' . $tempid . '.code.txt';
		file_put_contents ( $codePath, $code );
		//echo $code;
		

		$imgPath = $this->cachePath . '\\' . $tempid . '.gif';
		$wwwImgPath = $this->wwwCachePath . '/' . $tempid . '.gif';
		$mapPath = $this->cachePath . '\\' . $tempid . '.map';
		$batPath = $this->cachePath . '\\' . $tempid . '.bat';
		
		file_put_contents ( $batPath, "\"" . $this->dotPath . "\" \"" . $codePath . "\" -Tgif -o\"" . $imgPath . "\" -Kdot \n " . "\"" . $this->dotPath . "\" \"" . $codePath . "\" -Tcmapx -o\"" . $mapPath . "\" -Kdot" );
		exec ( "\"$batPath\"" );
		
		unlink ( $batPath );
		unlink ( $codePath );
		
		$res [0] = $wwwImgPath;
		$res [1] = file_get_contents ( $mapPath );
		$res [2] = 0;
		
		return $res;
	}
	
	public function renderMac() {
		$res = array ();
		$this->deleteOldFiles ();
		
		$tempid = time ();
		$code = $this->generateCode ();
		$codePath = $this->cachePath . '/' . $tempid . '.code.txt';
		file_put_contents ( $codePath, $code );
		//echo $code;
		

		$imgPath = $this->cachePath . '/' . $tempid . '.gif';
		$wwwImgPath = $this->wwwCachePath . '/' . $tempid . '.gif';
		$mapPath = $this->cachePath . '/' . $tempid . '.map';
		$batPath = $this->cachePath . '/' . $tempid . '.sh';
		
		system ( "#!/bin/sh \n" . "\"" . $this->dotPath . "\" \"" . $codePath . "\" -Tgif > \"" . $imgPath . "\"" );
		system ( "#!/bin/sh \n" . "\"" . $this->dotPath . "\" \"" . $codePath . "\" -Tcmapx > \"" . $mapPath . "\"" );
		
		unlink ( $codePath );
		
		$res [0] = $wwwImgPath;
		$res [1] = file_get_contents ( $mapPath );
		$res [2] = 0;
		
		return $res;
	}

}

?>
<?php

class GraphViz
{
	var $dotPath = "C:\\Program Files (x86)\\Graphviz2.26.3\\bin\\dot.exe";
	var $nodes = array();
	var $edges = array();
	var $cachePath;
	var $wwwCachePath;
	
	public function GraphViz()
	{
		$this->cachePath = PUBLIC_PATH."\\cache\\GraphViz";
		$this->wwwCachePath = "/cache/GraphViz";
	}
	
	public function addNode(Node $node)
	{
		$this->nodes[$node->name] = $node;
	}
	
	public function addEdge(Node $from, Node $to, $name=null)
	{
		$e = new Edge($from, $to, $name);
		$this->edges[] = $e;
	}
	
	public function generateCode()
	{
		$res = "digraph G {\n";
		
		foreach($this->nodes as $n)
		{
			$res .= "\"".$n->name."\" [".(trim($n->url)!=''?"URL=\"".$n->url."\"":"")." ".(trim($n->shape)!=''?" shape=\"".$n->shape."\"":"")."]\n";
		}
		
		foreach($this->edges as $e)
		{
			$res .= "\"".$e->from->name."\" -> \"".$e->to->name."\" [".(trim($e->name)!=''?"label=\"".$e->name."\"":"")."]\n";
		}
		
		$res .= "\n}";
		return $res;
	}
	
	public function renderWindows()
	{
		$res = array();
		
		$tempid = time();
		$code = $this->generateCode();
		$codePath = $this->cachePath.'\\'.$tempid.'.code.txt';
		file_put_contents($codePath, $code);
		//echo $code;
		
		$imgPath = $this->cachePath.'\\'.$tempid.'.gif';
		$wwwImgPath = $this->wwwCachePath.'/'.$tempid.'.gif';
		$mapPath = $this->cachePath.'\\'.$tempid.'.map';
		$batPath = $this->cachePath.'\\'.$tempid.'.bat';

		file_put_contents($batPath, "\"".$this->dotPath."\" \"".$codePath."\" -Tgif -o\"".$imgPath."\" -Kdot \n ".
							"\"".$this->dotPath."\" \"".$codePath."\" -Tcmapx -o\"".$mapPath."\" -Kdot");
		exec("\"$batPath\"");
		
		unlink($batPath);
		unlink($codePath);

		$res[0] = $wwwImgPath;
		$res[1] = file_get_contents($mapPath);
		$res[2] = 0;

		return $res;
	}
	
}

?>
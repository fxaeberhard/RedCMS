<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

class TreeStructure extends Block {
	var $_dbFieldsMap = array('orderBy' => 'text1');
	
}
class MenuBlock extends TreeStructure {
	
	function toJSON0($node) {
		$ret = array();
		if (get_class($node) == 'Action' || $node instanceof  TreeStructure) {	// This optim allows to look for child nodes only when required
			foreach ($node->getChildBlocks() as $it) {							// cuts a lot of queries, but what if a new type is used?
				$r = array('widget' => $it->type, 
					'label' => $it->label, 
					'href' => $it->getLink(),
					'action' => $it->action
				);
				if ($it->filter) $r['filter'] = $it->filter;
				
				$c = $this->toJSON0($it);
				if (sizeof($c) > '') $r['children'] = $c;
				$ret[] = $r;
			}
		}
		return $ret;
	}
	
	function getChildBlocks($orderBy=null) {
		$childs = parent::getChildBlocks($orderBy);
		$val ="[2611, 2604]";
		$indexes = json_decode($val);
		for ($i = 0, $l = sizeof($childs);$i<$l;$i++ ) {
			$cIndex = array_search($childs[$i]->id, $indexes);
			if ($cIndex !== false){
				$t = $childs[$cIndex];
				$childs[$cIndex] = $childs[$i];
				$childs[$i] = $t;
				
			}
		}
		return $childs;
		
	}
	function toJSON() {
		return $this->toJSON0($this);
	}
}
?>
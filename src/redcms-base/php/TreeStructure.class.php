<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.red-agent.com/license.html
*/

class TreeStructure extends Block {
	
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
	
	function toJSON() {
		return $this->toJSON0($this);
	}
}
?>
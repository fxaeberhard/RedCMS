<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class TreeStructure extends Block {
	
}
class MenuBlock extends TreeStructure {
	
	function getMenuItems() {
		$ret = array();
		foreach ($this->getChildBlocks() as $it) {
			$r = array('widget' => $it->fields['type'], 
				'label' => $it->fields['text1'], 
				'href' => $it->getLink(),
				'action' => $it->fields['text2']
			);
			if (isset($it->fields['text3'])) $r['filter'] = $it->fields['text3'];
			$ret[] = $r;
		}
		return $ret;
	}
}
?>
<?php
/* 
Copyright (c) 2011, Francois-Xavier Aeberhard All rights reserved.
Code licensed under the BSD License:
http://redcms.sourceforge.net/license.html
*/

class PageBlock extends Block {
	
	function getLabel(){
		return $this->fields['link'];
	}
	function render() {
		global $redCMS;
		
		//First render headers
		$template = $this->getTemplate();
		$template->display($redCMS->config['headerTemplate']);
		
		//Render page content
		$template = $this->getTemplate();
		$template->assign('siteBlocks', BlockManager::getBlocksBySelect("parentId = -1"));
		$template->display($this->fields['template']);
		
		//First render headers
		$template = $this->getTemplate();
		$template->assign('footerBlocks', BlockManager::getBlocksBySelect("parentId = -2"));
		$template->display($redCMS->config['footerTemplate']);
	}
}
?>